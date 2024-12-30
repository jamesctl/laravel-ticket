@php
    use App\Enums\Ticket as eTicket;
@endphp

<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
  <div class="modal-content">
    <div class="modal-header bg-dark white">
      <span class="modal-title" id="editModalLabel">Edit Status</span>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="bx bx-x"></i>
      </button>
    </div>

    {{ html()->form('put', route('admin.ticket.update_modal'))->class('d-inline')->open() }}

    <div class="modal-body">
      <div class="card-content">
        <div class="card-body">
          <div class="row">
            <div class="col-12">

              <fieldset class="form-group">
                <label for="basicInput">Admin name</label>
                <select class="form-control" id="modalUserList" name="user_id"></select>
              </fieldset>

              <fieldset class="form-group">
                <label for="helpInputTop">Status</label>
                <select class="form-control" id="statusTicketSelect" name="status">
                  <option value="{{eTicket::IS_NEW}}">New</option>
                  <option value="{{eTicket::IS_COMPLETE}}">Complete</option>
                  <option value="{{eTicket::IS_PROCESSING}}">Processing</option>
                  <option value="{{eTicket::CLOSE}}">Close</option>
                </select>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
        <i class="bx bx-x d-block d-sm-none"></i>
        <span class="d-none d-sm-block">Close</span>
      </button>

        <input type="hidden" name="ticket_id" id="ticket_id" value="">
        <button type="submit" class="btn btn-dark ml-1">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Accept</span>
        </button>
    </div>
    {{ html()->form()->close() }}

  </div>
</div>
</div>
