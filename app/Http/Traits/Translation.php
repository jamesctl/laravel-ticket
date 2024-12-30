<?php

namespace App\Http\Traits;

use App\Models\TranslatorLanguage;

trait Translation 
{
    public function getLanguages(string $key = null)
    {
        $langs = TranslatorLanguage::orderBy('locale')->get();
        if($key != null) {
            return $langs->pluck($key);
        }
        
        return $langs->pluck('name', 'locale');

    }

    /**
     * 
     * @return array
     */
    public function getDataLanguages()
    {
        $result = [];
        $language = $this->getLanguages();
        if (!empty($language)) {
            foreach ($language as $locale => $name) {
                $result[$locale]['title'] = "Title Updateing ...";
                $result[$locale]['content'] = "Content Updating ...";
            }
        }

        return $result;
    }
}