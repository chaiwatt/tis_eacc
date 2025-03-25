{{-- work on Certify\ApplicantController --}}
{{-- modal add address --}}
<style>
    .symbol-btn {
        width: 60px; /* ปรับความกว้างตามที่ต้องการ */
        margin: 5px; /* ช่องว่างระหว่างปุ่ม */
    }
/* เส้นขอบรอบตาราง */
.custom-bordered-table {
    border-collapse: separate;
    border: 0.5px solid #dee2e6; /* เส้นขอบรอบตาราง */
    border-spacing: 0; /* ไม่มีช่องว่างระหว่างเซลล์ */
}

/* เส้นขอบเฉพาะด้านซ้ายและขวาสำหรับ td และ th */
.custom-bordered-table td,
.custom-bordered-table th {
    border-left: 0.5px solid #dee2e6 !important; /* ขอบซ้าย */
    border-right: 0.5px solid #dee2e6 !important; /* ขอบขวา */
    border-top: none !important; /* ไม่มีขอบบน */
    border-bottom: none !important; /* ไม่มีขอบล่าง */
}

/* ยกเลิกเส้นขอบที่อาจซ้อนมาจาก Bootstrap */
.custom-bordered-table th,
.custom-bordered-table td {
    border-top: 0 !important;
    border-bottom: 0 !important;
}

/* เส้นขอบด้านล่างสุดของตาราง */
.custom-bordered-table tr:last-child td {
    border-bottom: none !important; /* ยกเลิกขอบล่างของแถวสุดท้าย */
}

    /* ปิดเอฟเฟกต์ hover */
    .table-no-hover tbody tr:hover {
        background-color: transparent !important;
    }

    .editable-div {
    width: 200px;
    min-height: 100px;
    white-space: pre-wrap;
    font-family: Arial, sans-serif;
    overflow-wrap: break-word;
    border: 1px solid #ccc;
    padding: 4px;
    outline: none;
}

.editable-div:focus {
    border-color: #666;
}

[id^="result"] {
    margin-top: 10px;
}
</style>


<div class="modal fade" id="modal-add-ib-scope">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">เพิ่มขอบข่ายหน่วยตรวจ (IB)</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
                <h5>
                  <span class="text-danger">*โปรดทราบ!! ถ้าไม่พบขอบข่ายที่ต้องการ โปรดติดต่อเจ้าหน้าที่เพื่อเพิ่มเติมขอบข่าย ==></span> <span><a href="{{url('certify/scope-request/lab-scope-request')}}" target="_blank">ขอเพิ่มขอบข่าย</a></span>
                </h5>
            </div>
            <div class="modal-body">
                <fieldset class="white-box">
                    <div class="row" id="select_wrapper">
                        <div class="col-md-4 form-group">
                            <label for="">สาขาการสอบเทียบ</label>
                            <select class="form-control" name="" id="cal_main_branch">
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">สาขา</label>
                            <select class="form-control" name="" id="main_category_ib">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="sub_category_ib_wrapper">
                            <label for="">สาขาการย่อย</label>
                            <select class="form-control" name="" id="sub_category_ib">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="scope_topic_ib_wrapper">
                            <label for="">ขอบข่ายย่อย1</label>
                            <select class="form-control" name="" id="scope_topic_ib">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="scope_detail_ib_wrapper">
                            <label for="">ขอบข่ายย่อย2</label>
                            <select class="form-control" name="" id="scope_detail_ib">
                            </select>
                        </div>
                    </div>

                </fieldset>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-right ml-2" id="button_add_ib_scope">
                    <span aria-hidden="true">เพิ่ม</span>
                </button>
            </div>
        </div>
    </div>
</div>



