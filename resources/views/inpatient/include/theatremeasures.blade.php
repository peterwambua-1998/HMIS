<div class="modal fade" id="theatre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document" style="width: 60vw">
      <div class="modal-content">
        <form action="{{ route('theatremeasures') }}" method="POST">
            @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Theatre Initiation Form</h5>
          
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-10">
              <label for="">Enter Surgeon Name: </label>
              <input type="text" name="surgon" id="" class="form-control">
            </div>
            <br>

            <div class="col-md-10">
              <label for="" >Enter Operation: procedure</label>
              <input type="text" name="operation_procedure" id="" class="form-control">
            </div>

            <br>


            <div class="col-md-10">
              <label for="" >Select Theatre Room</label>
              <select name="theatre_room" id="theatre_room">
                <option value="rooom 1">Room 1</option>
                <option value="rooom 2">Room 2</option>
              </select>
            </div>

            <br>

            <div class="col-md-10">
              <label for="dis3" class="control-label">{{__('Note')}}</label>
              
                  <textarea class="form-control" name="theatre_note" id="dis3" rows="3" cols="100"
                            placeholder="Enter note"></textarea>
              
            </div>

            <br>

            <div class="col-md-10">
              <label for="" class="control-label">Enter Start Time</label>

                <input type="time" name="start_time" id="" class="form-control" style="width: 140px">
            </div>
          </div>
          


              <input type="hidden" name="patient_id" value="{{ $patient->id }}">
              <input type="hidden" name="app_id" value="{{$appID}}">
              <input type="hidden" name="sendto" value="theatre">

            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
        </form>
      </div>
    </div>
</div>

