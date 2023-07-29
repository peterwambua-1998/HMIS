<div class="modal fade" id="radiology" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form action="{{route('radiologymeasures')}}" method="POST">
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Radiology And Imaging Request Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="CT Scan" id="defaultCheck1" name="ct_scan">
                <label class="form-check-label" for="defaultCheck1">
                    CT Scan
                </label>
            </div>
            <br>


            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="X-Ray" id="defaultCheck1" name="x_ray">
                <label class="form-check-label" for="defaultCheck1">
                    X-Ray
                </label>
            </div>

            <br>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Ultra Sound" id="defaultCheck1" name="ultra_sound">
                <label class="form-check-label" for="defaultCheck1">
                    Ultra Sound
                </label>
            </div>

            <br>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="mri" id="defaultCheck1" name="mri">
                <label class="form-check-label" for="defaultCheck1">
                    MRI
                </label>
            </div>

            <br>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="PET Scan" id="defaultCheck1" name="pet_scan">
                <label class="form-check-label" for="defaultCheck1">
                    PET Scan
                </label>
            </div>
            
            <br>

            <label for="">Doctor Note</label>
                    <textarea class="form-control" name="doc_note" rows="3" cols="100"
                        placeholder="Add Note"></textarea>

            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            <input type="hidden" name="app_id" value="{{$appID}}">
            <input type="hidden" name="sendto" value="radiology and imaging">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
    </div>
</div>

</div>


