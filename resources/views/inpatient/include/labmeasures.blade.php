<!-- Modal -->
<div class="modal fade" id="lab" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document" style="width: 60vw">
      <div class="modal-content">
        <form action="{{ route('measures') }}" method="POST">
            @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Test For</h5>
          
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="White blood cell (WBC)" id="defaultCheck1" name="whitebooldcells">
                        <label class="form-check-label" for="defaultCheck1">
                            White blood cell (WBC)
                        </label>
                      </div>
        
                      <br>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="red blood cell (RBC) counts" id="defaultCheck1" name="redbooldcells">
                        <label class="form-check-label" for="defaultCheck1">
                            red blood cell (RBC) counts
                        </label>
                      </div>
                      <br>
        
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="PT, prothrombin time" id="defaultCheck1" name="prothrombintime">
                        <label class="form-check-label" for="defaultCheck1">
                            PT, prothrombin time
                        </label>
                      </div>
                      <br>

                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="APTT, activated partial thromboplastin time" id="defaultCheck1" name="activatedpartialthromboplastin">
                        <label class="form-check-label" for="defaultCheck1">
                            APTT, activated partial thromboplastin time
                        </label>
                      </div>
                      <br>
        
        
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="AST, aspartate aminotransferase" id="defaultCheck1" name="aspartateaminotransferase">
                        <label class="form-check-label" for="defaultCheck1">
                            AST, aspartate aminotransferase
                        </label>
                      </div>
                      <br>
        
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="ALT, alanine aminotransferase" id="defaultCheck1" name="alanineaminotransferase">
                        <label class="form-check-label" for="defaultCheck1">
                            ALT, alanine aminotransferase
                        </label>
                      </div>

                      <br>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="LD, lactate dehydrogenase" id="defaultCheck1" name="mlactatedehydrogenase">
                        <label class="form-check-label" for="defaultCheck1">
                            LD, lactate dehydrogenase
                        </label>
                      </div>
                      <br>
        
        
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="BUN, blood urea nitrogen" id="defaultCheck1" name="bloodureanitrogen">
                        <label class="form-check-label" for="defaultCheck1">
                            BUN, blood urea nitrogen
                        </label>
                      </div>
                      <br>
        
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="WBC count w/differential" id="defaultCheck1" name="WBCcountWdifferential">
                        <label class="form-check-label" for="defaultCheck1">
                            WBC count w/differential
                        </label>
                      </div>

                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Quantitative immunoglobulin’s (IgG, IgA, IgM)" id="defaultCheck1" name="Quantitativeimmunoglobulin">
                        <label class="form-check-label" for="defaultCheck1">
                            Quantitative immunoglobulin’s (IgG, IgA, IgM)
                        </label>
                      </div>
                      <br>
        
        
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Erythrocyte sedimentation rate (ESR)" id="defaultCheck1" name="Erythrocytesedimentationrate">
                        <label class="form-check-label" for="defaultCheck1">
                            Erythrocyte sedimentation rate (ESR)
                        </label>
                      </div>
                      <br>
        
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Quantitative alpha-1-antitrypsin (AAT) level" id="defaultCheck1" name="alpha_antitrypsin">
                        <label class="form-check-label" for="defaultCheck1">
                            Quantitative alpha-1-antitrypsin (AAT) level
                        </label>
                      </div>
                      <br>


                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Retic count" id="defaultCheck1" name="Reticcount">
                        <label class="form-check-label" for="defaultCheck1">
                            Retic count
                        </label>
                      </div>

                      <br>

                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Arterial blood gasses (ABGs)" id="defaultCheck1" name="arterialbloodgasses">
                        <label class="form-check-label" for="defaultCheck1">
                            Arterial blood gasses (ABGs)
                        </label>
                      </div>
                </div>
                <br>
                <div class="col-md-6 mt-4">
                    
                    <label for="">Doctor Note</label>
                    <textarea class="form-control" name="doc_note" rows="3" cols="100"
                        placeholder="Add Note"></textarea>
                </div>

            </div>
            


              <input type="hidden" name="patient_id" value="{{ $patient->id }}">
              <input type="hidden" name="app_id" value="{{$appID}}">
              <input type="hidden" name="sendto" value="lab">

            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
        </form>
      </div>
    </div>
</div>