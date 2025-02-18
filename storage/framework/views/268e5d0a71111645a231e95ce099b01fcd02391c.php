<div class="modal fade" id="modal-add-cb-scope-bcms">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">เพิ่มขอบข่าย CB</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
                <h5>
                  <span class="text-danger">*โปรดทราบ!! ถ้าไม่พบขอบข่ายที่ต้องการ โปรดติดต่อเจ้าหน้าที่เพื่อเพิ่มเติมขอบข่าย ==></span> <span><a href="<?php echo e(url('certify/scope-request/lab-scope-request')); ?>" target="_blank">ขอเพิ่มขอบข่าย</a></span>
                </h5>
            </div>
            <div class="modal-body">
                
                    <div class="row" >
                        <div class="col-md-12" style="padding-top:10px !important">
                            <input type="checkbox" id="toggle-all-cbms-checkbox">
                            <label for="toggle-all-cbms-checkbox">เลือกทั้งหมด</label>
                        </div>
                      <div class="col-md-12" id="cb_scope_bcms_wrapper" >

                      </div>
                
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-right ml-2" id="button_add_cb_scope_bcms">
                    <span aria-hidden="true">เพิ่ม</span>
                </button>
            </div>
        </div>
    </div>
</div>