<div class="modal fade" id="dialysis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document" style="width: 60vw">
      <div class="modal-content">
        <form action="{{ route('introdialysis') }}" method="POST">
            @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dialysis Patient Registration</h5>
          
        </div>
        <div class="modal-body">

          
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 30px;">
                    <h5>Pre Dialysis Vitals</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Bp (mmHg)</label>
                            <input type="text" class="form-control" name="pre_bp" value="{{$triage->blood_pressure}}">
                        </div>
                       
                        <div class="col-md-4">
                            <label for="">Weight (kg)</label>
                            <input type="text" class="form-control" name="pre_weight" value="{{ $triage->weight }}">
                        </div>
    
                        <div class="col-md-4">
                            <label for="">Temp (°C)</label>
                            <input type="text" class="form-control" name="pre_temp" value="{{$triage->temp}}">
                        </div>
                    </div>
                    
                </div>
                
            </div>


            <div class="row">
                <div class="col-md-6">
                    <label for="">Type Of Renal Failure</label>
                    <input type="text" class="form-control" name="renal_failure">
                </div>
                <div class="col-md-6">
                    <label for="">Blood Group</label>
                    <input type="text" class="form-control" name="blood_group">
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-6">
                    <label for="">Session Start Time</label>
                    <input type="time" name="start_time" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="">Doctor Incharge</label>
                    <input type="text" class="form-control" name="doc_incharge">
                </div>
            </div>

            <br>


            <div class="row">
                <div class="col-md-12">
                    <label for="">Approved By</label>
                    <input type="text" class="form-control" name="approved_by">
                </div>
            </div>

            <br>

            <div class="row">

                <div class="col-md-12">
                    <label for="dis3" class="control-label">{{__('Diagnosis')}}</label>
              
                  <textarea class="form-control" name="diagnosis" id="dis3" rows="3" cols="100"
                            placeholder="Enter Diagnosis"></textarea>
                </div>
                
              
            </div>


            <br>

            <div class="row">

                <div class="col-md-12">
                    <label for="dis3" class="control-label">{{__('Note')}}</label>
              
                  <textarea class="form-control" name="note" id="dis3" rows="3" cols="100"
                            placeholder="Enter note"></textarea>
                </div>
                
              
            </div>


            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            <input type="hidden" name="app_id" value="{{$appID}}">
            <input type="hidden" name="sendto" value="dialysis">

            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
        </form>
      </div>
    </div>
</div>




