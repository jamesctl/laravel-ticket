<?php

namespace App\Http\Controllers\Admin;

use App\Models\WebsiteManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TranslatorTranslations;
use App\Models\Setting;
use App\Http\Traits\Translation;
use Illuminate\Support\Facades\Validator;

class WebsiteManagementController extends AdminBaseController
{
    // private $__path='upload/testimonial';
    use Translation;

    public function index(Request $request)
    {
        $model = new WebsiteManagement();
        $translation = new TranslatorTranslations();

        $data = $request->all();
        $items = $model->getListPagination($data);
        $param['status'] = $request->input('status') ?? null;
        $param['name'] = $request->input('name') ?? null;

        $listTrans = [];
        if (count($items) != 0) {
            $arrId = collect(collect($items)['data'])->pluck('id')->toArray();
            $listTrans = $translation->getListTrans($arrId, 'website_management');
            if (count($listTrans) != 0) {
                $listTrans = collect($listTrans)->groupBy('item');
            }
        }

        $listTransPrice = [];
        if (count($items) != 0) {
            // $arrId = collect(collect($items)['data'])->pluck('id')->toArray();
            $listTransPrice = $translation->getListTransPrice($arrId, 'website_management');
            if (count($listTransPrice) != 0) {
                $listTransPrice = collect($listTransPrice)->groupBy('item');
            }
        }

        return view('admin.website-management.index', compact(
            'items', 'param', 'listTrans', 'listTransPrice'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.website-management.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->input('title-' . LANGUAGE);

        // Validate
        $languages = getListLanguage(false);
        $rules = [
        ];
        foreach ($languages as $lang) {
            $rules['title-' . $lang->locale] = 'required|string|max:255';
            $rules['short_description-' . $lang->locale] = 'required|string|min:1';
            $rules['description-' . $lang->locale] = 'required|string|min:1';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('error', trans('general.validate_error'));
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $description = $request->input('description-' . LANGUAGE);
        $shortDescription = $request->input('short_description-' . LANGUAGE);
        $price = $request->input('price-' . LANGUAGE);

        $item = new WebsiteManagement();
        $item->sort = $request->input('sort');
        $item->status = $request->input('status');
        $item->title = $title;
        $item->short_description = $shortDescription;
        $item->description = $description;
        $item->price = $price;

        $item->save();

        handleTranslate($item, $request);
    
        $message = $request->id ? trans('general.updatedSuccessfully') : trans('general.createdSuccessfully');
        Session::flash('success', $message);
        return redirect(url('admin/website-management'));
    }

    public function infoPage($id,$page) {
        $model = new WebsiteManagement();
        $item = $model->find($id);

        // Translation
        $translation = new TranslatorTranslations();
        $keyTitle = str_replace('translatable.', '', $item['title_translation']);
        $keyDescription = str_replace('translatable.', '', $item['description_translation']);
        $keyShortDescription = str_replace('translatable.', '', $item['short_description_translation']);
        $keyPrice = str_replace('translatable.', '', $item['price_translation']);

        $listTrans = $translation->getListTransDetail($keyTitle, $keyDescription,$keyShortDescription, $keyPrice);
        if (count($listTrans) != 0) {
            $listTrans = collect($listTrans)->groupBy('item');
            $listTransDetail[$keyTitle] = collect($listTrans[$keyTitle])->keyBy('locale');
            if (!empty($keyDescription)) {
                $listTransDetail[$keyDescription] = collect($listTrans[$keyDescription])->keyBy('locale');
            }

            if (!empty($keyShortDescription)) {
                $listTransDetail[$keyShortDescription] = collect($listTrans[$keyShortDescription])->keyBy('locale');
            }

            if (!empty($keyPrice)) {
                $listTransDetail[$keyPrice] = collect($listTrans[$keyPrice])->keyBy('locale');
            }
        }

        return view('admin.website-management.'.$page, compact(
            'item', 'listTransDetail', 'keyTitle', 'keyDescription', 'keyShortDescription', 'keyPrice'
        ));
    }
    
    public function show($id)
    {
        return $this->infoPage($id,'detail');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->infoPage($id,'edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate
        $languages = getListLanguage(false);
        $rules = [];
        foreach ($languages as $lang) {
            $rules['title-' . $lang->locale] = 'required|string|max:255';
            $rules['short_description-' . $lang->locale] = 'required|string|min:1';
            $rules['description-' . $lang->locale] = 'required|string|min:1';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Session::flash('error', trans('general.validate_error'));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new WebsiteManagement();
        $item = $model->find($id);

        // $item->fill($request->except('_token'));
        // $item->save();

        $title = $request->input('title-' . LANGUAGE);

        // Update DB
        $description = $request->input('description-' . LANGUAGE);
        $shortDescription = $request->input('short_description-' . LANGUAGE);
        $price = $request->input('price-' . LANGUAGE);

        // $seoModel = new Seo();
        // $item = $seoModel->find($id);

        $item->sort = $request->input('sort');
        $item->status = $request->input('status');
        $item->title = $title;
        $item->description = $description;
        $item->short_description = $shortDescription;
        $item->price = $price;

        $item->save();
        handleTranslate($item, $request);

        Session::flash('success', trans('general.updatedSuccessfully'));
        return redirect(url('admin/website-management'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model= new WebsiteManagement();
        $item = $model->find($id);
        if($item) {
            $item->delete();
        }

        Session::flash('success', trans('general.deletedSuccessfully'));
        return redirect(url('admin/website-management'));
    }

    public function translate()
    {
        $language = $this->getLanguages();
        $settings = new Setting;

        $settings = $settings->where('setting_key', 'website-management')->first();
        if (!$settings) {
            $settings = Setting::create([
                'setting_key'   => 'website-management',
                'setting_name'  => 'website management',
                'setting_value' => json_encode($this->getDataLanguages())
            ]);
        }

        $settings->setting_value = json_decode($settings->setting_value, true);

        return view('admin.website-management.translate', compact('language', 'settings'));
    }
}
