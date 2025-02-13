var globalTypeNumber = null;
var globalBranchNumber = null;
var selectedScopeIndex;
var buttonColors = ['btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-danger'];

var facilityTypes = [
    { text: "ประเภท1 สถานปฏิบัติการถาวร (Permanent facilities)", id: "pl_2_1_branch" },
    { text: "ประเภท2 สถานปฏิบัติการนอกสถานที่ (Sites away from its permanent facilities)", id: "pl_2_2_branch" },
    { text: "ประเภท3 สถานปฏิบัติการเคลื่อนที่ (Mobile facilities)", id: "pl_2_3_branch" },
    { text: "ประเภท4 สถานปฏิบัติการชั่วคราว (Temporary facilities)", id: "pl_2_4_branch" },
    { text: "ประเภท5 สถานปฏิบัติการหลายสถานที่ (Multi-site facilities)", id: "pl_2_5_branch" }
];

$(document).ready(function () {
      
    // ดึงข้อมูลจาก session storage เมื่อเอกสารถูกโหลด
    var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    
    // ถ้ามีข้อมูลใน session storage ให้ render ในตาราง
    if (lab_addresses_array.length > 0) {
        renderTable(lab_addresses_array);
    }
    createLabMainAddressStorage()
});




function createLabMainAddressStorage()
{
    // ดึงข้อมูล lab_main_address จาก sessionStorage
    var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address'));
    console.log('create main storage');
    // ถ้าไม่มีข้อมูล lab_main_address ให้สร้างค่า default
    if (!lab_main_address) {
        lab_main_address = {
            lab_type: 'main',
            address_number_add: "",
            village_no_add: "",
            address_city_add: "",
            address_city_text_add: "",
            address_district_add: "",
            sub_district_add: "",
            postcode_add: "",
            lab_address_no_eng_add: "",
            lab_province_text_eng_add: "",
            lab_province_eng_add: "",
            lab_amphur_eng_add: "",
            lab_district_eng_add: "",
            lab_moo_eng_add: "",
            lab_soi_eng_add: "",
            lab_street_eng_add: "",
            lab_types: {
                pl_2_1_main: $('#pl_2_1').is(':checked') 
                    ? (Array.isArray(lab_main_address?.lab_types?.pl_2_1_main) ? lab_main_address.lab_types.pl_2_1_main : 1)
                    : 0,
                pl_2_2_main: $('#pl_2_2').is(':checked') 
                    ? (Array.isArray(lab_main_address?.lab_types?.pl_2_2_main) ? lab_main_address.lab_types.pl_2_2_main : 1)
                    : 0,
                pl_2_3_main: $('#pl_2_3').is(':checked') 
                    ? (Array.isArray(lab_main_address?.lab_types?.pl_2_3_main) ? lab_main_address.lab_types.pl_2_3_main : 1)
                    : 0,
                pl_2_4_main: $('#pl_2_4').is(':checked') 
                    ? (Array.isArray(lab_main_address?.lab_types?.pl_2_4_main) ? lab_main_address.lab_types.pl_2_4_main : 1)
                    : 0,
                pl_2_5_main: $('#pl_2_5').is(':checked') 
                    ? (Array.isArray(lab_main_address?.lab_types?.pl_2_5_main) ? lab_main_address.lab_types.pl_2_5_main : 1)
                    : 0
            },
            address_soi_add: "",
            address_street_add: ""
        };

        // บันทึกข้อมูลใหม่กลับไปที่ session storage
        sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
    } else {
        // หากมีข้อมูล lab_main_address อยู่แล้ว ให้ใช้ข้อมูลนั้น
        console.log('Lab Main Address loaded:', lab_main_address);
        console.log(lab_main_address.lab_types.pl_2_5_main);
        // คุณสามารถทำงานกับ lab_main_address ที่ดึงมานี้ต่อไปได้ เช่นแสดงข้อมูลในฟอร์มหรืออื่น ๆ
        $('#pl_2_1').iCheck(lab_main_address.lab_types.pl_2_1_main != 0 ? 'check' : 'uncheck');
        $('#pl_2_2').iCheck(lab_main_address.lab_types.pl_2_2_main != 0 ? 'check' : 'uncheck');
        $('#pl_2_3').iCheck(lab_main_address.lab_types.pl_2_3_main != 0 ? 'check' : 'uncheck');
        $('#pl_2_4').iCheck(lab_main_address.lab_types.pl_2_4_main != 0 ? 'check' : 'uncheck');
        $('#pl_2_5').iCheck(lab_main_address.lab_types.pl_2_5_main != 0 ? 'check' : 'uncheck');

       
        
    } 
}













$('#show_add_address').click(function(){
    // รีเซ็ตค่าของฟิลด์ต่างๆ

    $('#address_number_add_modal').val('');
    $('#village_no_add_modal').val('');
    $('#address_city_add_modal').val('');
    $('#address_district_add_modal').val('');
    $('#sub_district_add_modal').val('');
    $('#postcode_add_modal').val('');
    $('#lab_address_no_eng_add_modal').val('');
    $('#lab_province_eng_add_modal').val('');
    $('#lab_amphur_eng_add_modal').val('');
    $('#lab_district_eng_add_modal').val('');
    $('#lab_moo_eng_add_modal').val('');
    $('#address_soi_add_modal').val('');
    $('#address_street_add_modal').val('');
    $('#lab_soi_eng_add_modal').val('');
    $('#lab_street_eng_add_modal').val('');
    
    
    // รีเซ็ต checkbox
    $('#pl_2_1_branch').iCheck('uncheck');
    $('#pl_2_2_branch').iCheck('uncheck');
    $('#pl_2_3_branch').iCheck('uncheck');
    $('#pl_2_4_branch').iCheck('uncheck');
    $('#pl_2_5_branch').iCheck('uncheck');


    // เปลี่ยนข้อความของปุ่มเป็น "บันทึก"
    $('#create_address').text('บันทึก');

    // แสดง modal
    $('#modal-add-address').modal('show');
});

$('#create_address').click(function() {
    // ดึงค่าจากฟิลด์ต่างๆ
    var lab_address = {
        lab_type: 'branch',
        address_number_add_modal: $('#address_number_add_modal').val(),
        village_no_add_modal: $('#village_no_add_modal').val(),
        address_city_add_modal: $('#address_city_add_modal').val(),
        address_city_text_add_modal: $('#address_city_add_modal option:selected').text(), 
        address_district_add_modal: $('#address_district_add_modal').val(),
        sub_district_add_modal: $('#sub_district_add_modal').val(),
        postcode_add_modal: $('#postcode_add_modal').val(),
        lab_address_no_eng_add_modal: $('#lab_address_no_eng_add_modal').val(),
        lab_province_text_eng_add_modal: $('#lab_province_eng_add_modal option:selected').text(),
        lab_province_eng_add_modal: $('#lab_province_eng_add_modal').val(),
        lab_amphur_eng_add_modal: $('#lab_amphur_eng_add_modal').val(),
        lab_district_eng_add_modal: $('#lab_district_eng_add_modal').val(),
        lab_moo_eng_add_modal: $('#lab_moo_eng_add_modal').val(),
        lab_soi_eng_add_modal: $('#lab_soi_eng_add_modal').val(),
        lab_street_eng_add_modal: $('#lab_street_eng_add_modal').val(),
        lab_types: {
            pl_2_1_branch: $('#pl_2_1_branch').is(':checked') ? 1 : 0,
            pl_2_2_branch: $('#pl_2_2_branch').is(':checked') ? 1 : 0,
            pl_2_3_branch: $('#pl_2_3_branch').is(':checked') ? 1 : 0,
            pl_2_4_branch: $('#pl_2_4_branch').is(':checked') ? 1 : 0,
            pl_2_5_branch: $('#pl_2_5_branch').is(':checked') ? 1 : 0
        },
        address_soi_add_modal: $('#address_soi_add_modal').val(),
        address_street_add_modal: $('#address_street_add_modal').val()
    };

    // ตรวจสอบว่าฟิลด์ที่ต้องไม่ว่างมีค่าหรือไม่
    if (!lab_address.address_number_add_modal || 
        !lab_address.village_no_add_modal || 
        !lab_address.address_city_add_modal || 
        !lab_address.address_district_add_modal || 
        !lab_address.sub_district_add_modal || 
        !lab_address.postcode_add_modal || 
        !lab_address.lab_address_no_eng_add_modal || 
        !lab_address.lab_province_eng_add_modal || 
        !lab_address.lab_amphur_eng_add_modal || 
        !lab_address.lab_district_eng_add_modal || 
        !lab_address.lab_moo_eng_add_modal) {

        alert('กรุณากรอกข้อมูล * ให้ครบ');
        return; // หยุดการทำงานถ้ามีฟิลด์ที่ยังไม่ได้กรอก
    }


    // ตรวจสอบว่ามีการเลือก type อย่างน้อยหนึ่งรายการ
    var isAnyTypeSelected = Object.values(lab_address.lab_types).some(function(value) {
        return value === 1;
    });

    if (!isAnyTypeSelected) {
        alert('กรุณาเลือกประเภทอย่างน้อยหนึ่งรายการ');
        return; // หยุดการทำงานถ้าไม่มีการเลือก type
    }

    // ดึง array จาก session storage ถ้าไม่มีให้สร้างใหม่
    var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    // เพิ่ม lab_address ใหม่เข้าไปใน array
    lab_addresses_array.push(lab_address);

    // บันทึก array กลับไปที่ session storage
    sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));

    // แสดง array เพื่อให้เห็นข้อมูลที่ถูกเพิ่มเข้าไป
    console.log(lab_addresses_array);
    renderTable(lab_addresses_array);
    
    $('#modal-add-address').modal('hide'); // Toggle modal
});


function renderTable(lab_addresses_array) {
    // ลบเนื้อหาเก่าใน tbody ก่อน
    $('#lab_address_body').empty();
    $('#lab_address_with_scope_body').empty();


    var default_scope_row = `
            <tr>
                <td class="text-center" style="vertical-align:top">1</td>
                <td style="vertical-align:top">
                    สำนักงานใหญ่
                </td>
                <td class="text-center" id="checkbox-main-branch-container">
                    
                </td>
                <td class="text-center" id="main-branch-container">
                    
                </td>
            </tr>
        `;
    $('#lab_address_with_scope_body').append(default_scope_row);
    // loop ข้อมูลใน array เพื่อแสดงในตาราง
    lab_addresses_array.forEach(function(address, index) {
        // Render ตารางแรก
        var row1 = `
            <tr>
                <td class="text-center" style="vertical-align:top">${index + 1}</td>
                <td style="vertical-align:top">
                    เลขที่ ${address.address_number_add_modal}, หมู่ ${address.village_no_add_modal}, 
                    แขวง/อำเภอ${address.sub_district_add_modal}, เขต/อำเภอ${address.address_district_add_modal}, 
                    จังหวัด${address.address_city_text_add_modal}
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-xs addressEdit" data-index="${index}">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-xs addressDelete" data-index="${index}">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#lab_address_body').append(row1);

        // สร้างปุ่มประเภทจากค่าของ checkbox
        var typesHtml = '';
        if (address.lab_types.pl_2_1_branch) {
            typesHtml += `<a class="btn btn-primary btn-xs add-lab-scope" data-type="1" data-branch="${index}">ประเภท 1</a> `;
        }
        if (address.lab_types.pl_2_2_branch) {
            typesHtml += `<a class="btn btn-success btn-xs add-lab-scope" data-type="2" data-branch="${index}">ประเภท 2</a> `;
        }
        if (address.lab_types.pl_2_3_branch) {
            typesHtml += `<a class="btn btn-info btn-xs add-lab-scope" data-type="3" data-branch="${index}">ประเภท 3</a> `;
        }
        if (address.lab_types.pl_2_4_branch) {
            typesHtml += `<a class="btn btn-warning btn-xs add-lab-scope" data-type="4" data-branch="${index}">ประเภท 4</a> `;
        }
        if (address.lab_types.pl_2_5_branch) {
            typesHtml += `<a class="btn btn-danger btn-xs add-lab-scope" data-type="5" data-branch="${index}">ประเภท 5</a> `;
        }

        
        commonScopeHtml = `<a class="btn btn-primary btn-xs add-lab-scope data-type="" data-branch="${index}">เพิ่มขอบข่ายร่วม</a>`;

        // Render ตารางที่สอง
        var row2 = `
            <tr>
                <td class="text-center" style="vertical-align:top">${index + 2}</td>
                <td style="vertical-align:top">
                    เลขที่ ${address.address_number_add_modal}, หมู่ ${address.village_no_add_modal}, 
                    แขวง/อำเภอ${address.sub_district_add_modal}, เขต/อำเภอ${address.address_district_add_modal}, 
                    จังหวัด${address.address_city_text_add_modal}
                </td>
                <td class="text-center">
                    <div class="checkbox checkbox-success">
                        <input id="checkbox_${index + 1}" type="checkbox" data-branch="${index}" checked class="lab-scope-checkbox">
                        <label for="checkbox_${index + 1}">
                            <span class="font-16"></span>
                        </label>
                    </div>
                </td>
                <td class="text-center types-container">
                    ${commonScopeHtml}
                </td>
            </tr>
        `;
        $('#lab_address_with_scope_body').append(row2);
    });

    // เพิ่ม event listener สำหรับปุ่มลบ
    $(document).on('click', '.addressDelete', function() { 
    // $('.addressDelete').click(function() {
        var index = $(this).data('index');
        lab_addresses_array.splice(index, 1); // ลบที่ตำแหน่ง index นั้น
        sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array)); // บันทึกการเปลี่ยนแปลง
        renderTable(lab_addresses_array); // แสดงข้อมูลใหม่ในตารางทั้งสอง
    });

    // เพิ่ม event listener สำหรับปุ่มแก้ไข
    $(document).on('click', '.addressEdit', function() { 
        var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
        var index = $(this).data('index');
        var address = lab_addresses_array[index];

        // console.log(address);

        // โหลดข้อมูลกลับเข้าสู่ฟอร์ม
        $('#address_number_add_modal').val(address.address_number_add_modal);
        $('#village_no_add_modal').val(address.village_no_add_modal);
        // กำหนดค่า select box
        $('#address_city_add_modal').val(address.address_city_add_modal).change();
        $('#lab_province_eng_add_modal').val(address.lab_province_eng_add_modal).change();

        $('#address_district_add_modal').val(address.address_district_add_modal);
        $('#sub_district_add_modal').val(address.sub_district_add_modal);
        $('#postcode_add_modal').val(address.postcode_add_modal);
        $('#lab_address_no_eng_add_modal').val(address.lab_address_no_eng_add_modal);
        $('#lab_amphur_eng_add_modal').val(address.lab_amphur_eng_add_modal);
        $('#lab_district_eng_add_modal').val(address.lab_district_eng_add_modal);
        $('#lab_moo_eng_add_modal').val(address.lab_moo_eng_add_modal);
        $('#lab_soi_eng_add_modal').val(address.lab_soi_eng_add_modal);
        $('#lab_street_eng_add_modal').val(address.lab_street_eng_add_modal);

        $('#pl_2_1_branch').iCheck(address.lab_types.pl_2_1_branch != 0 ? 'check' : 'uncheck');
        $('#pl_2_2_branch').iCheck(address.lab_types.pl_2_2_branch != 0 ? 'check' : 'uncheck');
        $('#pl_2_3_branch').iCheck(address.lab_types.pl_2_3_branch != 0 ? 'check' : 'uncheck');
        $('#pl_2_4_branch').iCheck(address.lab_types.pl_2_4_branch != 0 ? 'check' : 'uncheck');
        $('#pl_2_5_branch').iCheck(address.lab_types.pl_2_5_branch != 0 ? 'check' : 'uncheck');

        // เปลี่ยนข้อความของปุ่มเป็น "แก้ไข"
        $('#create_address').text('แก้ไข');

        // เปลี่ยนหัวข้อ modal เป็น "แก้ไขที่อยู่"
        $('#address-modal-title').text('แก้ไขที่อยู่');

        $(document).on('click', '#create_address', function() {    
            // อัปเดตข้อมูลใน array
            lab_addresses_array[index] = {
                lab_type: 'branch',
                address_number_add_modal: $('#address_number_add_modal').val(),
                village_no_add_modal: $('#village_no_add_modal').val(),
                address_city_add_modal: $('#address_city_add_modal').val(),
                address_city_text_add_modal: $('#address_city_add_modal option:selected').text(),
                address_district_add_modal: $('#address_district_add_modal').val(),
                sub_district_add_modal: $('#sub_district_add_modal').val(),
                postcode_add_modal: $('#postcode_add_modal').val(),
                lab_address_no_eng_add_modal: $('#lab_address_no_eng_add_modal').val(),
                lab_province_text_eng_add_modal: $('#lab_province_eng_add_modal option:selected').text(),
                lab_province_eng_add_modal: $('#lab_province_eng_add_modal').val(),
                lab_amphur_eng_add_modal: $('#lab_amphur_eng_add_modal').val(),
                lab_district_eng_add_modal: $('#lab_district_eng_add_modal').val(),
                lab_moo_eng_add_modal: $('#lab_moo_eng_add_modal').val(),
                lab_soi_eng_add_modal: $('#lab_soi_eng_add_modal').val(),
                lab_street_eng_add_modal: $('#lab_street_eng_add_modal').val(),
                lab_types: {
                    pl_2_1_branch: $('#pl_2_1_branch').is(':checked') 
                        ? (Array.isArray(address.lab_types.pl_2_1_branch) ? address.lab_types.pl_2_1_branch : 1)
                        : 0,
                    pl_2_2_branch: $('#pl_2_2_branch').is(':checked') 
                        ? (Array.isArray(address.lab_types.pl_2_2_branch) ? address.lab_types.pl_2_2_branch : 1)
                        : 0,
                    pl_2_3_branch: $('#pl_2_3_branch').is(':checked') 
                        ? (Array.isArray(address.lab_types.pl_2_3_branch) ? address.lab_types.pl_2_3_branch : 1)
                        : 0,
                    pl_2_4_branch: $('#pl_2_4_branch').is(':checked') 
                        ? (Array.isArray(address.lab_types.pl_2_4_branch) ? address.lab_types.pl_2_4_branch : 1)
                        : 0,
                    pl_2_5_branch: $('#pl_2_5_branch').is(':checked') 
                        ? (Array.isArray(address.lab_types.pl_2_5_branch) ? address.lab_types.pl_2_5_branch : 1)
                        : 0
                },
                address_soi_add_modal: $('#address_soi_add_modal').val(),
                address_street_add_modal: $('#address_street_add_modal').val()
            };
                // บันทึก array กลับไปที่ session storage
                sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));

                // แสดง array เพื่อให้เห็นข้อมูลที่ถูกเพิ่มเข้าไป
                console.log(lab_addresses_array);
                renderTable(lab_addresses_array);

                // ซ่อน modal และเปลี่ยนปุ่มกลับเป็น "เพิ่ม"
                $('#modal-add-address').modal('hide');
                $('#create_address').text('เพิ่ม');
                $('#address-modal-title').text('เพิ่มที่อยู่สาขา');
        });

        // แสดง modal ให้แก้ไขข้อมูล
        $('#modal-add-address').modal('show');
    });




    // ใช้ event delegation สำหรับปุ่ม add-lab-scope
    $(document).on('click', '.add-lab-scope', function() {
        globalTypeNumber = $(this).data('type');
        globalBranchNumber = $(this).data('branch');

        // var isChecked = $('#checkbox_' + (globalBranchNumber+1)).is(':checked');

        // console.log(isChecked);

        console.log(globalTypeNumber);
        console.log(globalBranchNumber);
        var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

        if(typeof globalTypeNumber === 'undefined'){
            var diffScopeFound = false;
            // ดึงข้อมูล lab_addresses_array จาก sessionStorage หรือสร้าง array ใหม่ถ้าไม่มี
        

            if (lab_addresses_array[globalBranchNumber]) {
                var lab_types = lab_addresses_array[globalBranchNumber].lab_types;

                var arrayLengths = [];

                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key])) {
                        // เก็บ length ของแต่ละ array ใน arrayLengths
                        arrayLengths.push(lab_types[key].length);
                    }
                }
                // ตรวจสอบว่า length ของทุก array เท่ากันหรือไม่
                var allEqualLengths = arrayLengths.every(function(length, _, arr) {
                    return length === arr[0];
                });
            
                if (!allEqualLengths) {
                    // alert('จำนวนรายการใน array ของ lab_types ไม่เท่ากัน');
                    diffScopeFound = true;
                } 
                else 
                {
                    console.log('จำนวนรายการใน array ของ lab_types เท่ากันทั้งหมด');
                    // เริ่มตรวจสอบค่าภายใน array ของแต่ละ lab_types[key]
                    var referenceItem;
                    for (var key in lab_types) {
                        if (Array.isArray(lab_types[key])) {
                            referenceItem = lab_types[key]; // ใช้รายการแรกเป็น reference
                            break;
                        }
                    }

                    for (var key in lab_types) {
                        if (Array.isArray(lab_types[key])) {
                            for (var index = 0; index < lab_types[key].length; index++) {
                                var item = lab_types[key][index];
                                console.log('index', index);
                                if (
                                    item['cal_instrument'] !== referenceItem[index]['cal_instrument'] ||
                                    item['cal_instrumentgroup'] !== referenceItem[index]['cal_instrumentgroup'] ||
                                    item['cal_main_branch'] !== referenceItem[index]['cal_main_branch'] ||
                                    item['cal_parameter_one'] !== referenceItem[index]['cal_parameter_one'] ||
                                    item['cal_parameter_two'] !== referenceItem[index]['cal_parameter_two']
                                ) {
                                    // alert(`พบค่าที่ไม่เหมือนกันใน ${key} ที่ index ${index}`);
                                    diffScopeFound = true;
                                    break; // หยุดการทำงานของ for loop ภายในเมื่อเจอค่าที่ไม่เหมือนกัน
                                }
                            }

                            if (diffScopeFound) {
                                break; // หยุดการทำงานของ for loop หลักเมื่อเจอค่าที่ไม่เหมือนกัน
                            }
                        }
                    }
    
                }
                
                var foundValue = false; // ตัวแปรเพื่อบันทึกว่าพบค่า 1 หรือไม่
                var foundArray = false; // ตัวแปรเพื่อบันทึกว่าพบ array หรือไม่

                for (var key in lab_types) {
                    if (lab_types[key] == 1) {
                        foundValue = true; // พบค่า 1
                    }

                    if (Array.isArray(lab_types[key])) {
                        referenceItem = lab_types[key]; // ใช้ array นี้เป็น reference
                        foundArray = true; // พบ array
                    }

                    // ถ้าพบทั้งค่า 1 และ array ให้ break ออกจาก loop
                    if (foundValue && foundArray) {
                        diffScopeFound = true;
                        // alert('จำนวนรายการใน array ของ lab_types ปนกับค่า 1');
                        break;
                    }
                }

            } else {
                console.log('globalBranchNumber is undefined or lab_addresses_array does not exist for this branch.');
            }
        }

        if (diffScopeFound === true && typeof globalTypeNumber === 'undefined') {
            // alert('ตรวจพบ Scope ของแต่ละประเภทแตกต่างกัน โปรดเลือกประเภทหลัก ประเภทอื่น ๆ ถูกปรับ scope ร่วมกับประเภทที่เลือก');

            // ตรวจสอบว่ามีข้อมูลใน globalBranchNumber หรือไม่
            if (lab_addresses_array[globalBranchNumber]) {
                var lab_types = lab_addresses_array[globalBranchNumber].lab_types;

                // เคลียร์ตัวเลือกทั้งหมดใน select element ก่อนด้วย jQuery
                var $selectMainType = $('#select_main_type');
                $selectMainType.empty(); // เคลียร์ตัวเลือกทั้งหมด

                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key])) {
                        // ตรวจสอบว่าคีย์ตรงกับ id ใน facilityTypes หรือไม่
                        var matchedFacility = facilityTypes.find(function(facility) {
                            return facility.id === key;
                        });

                        // ถ้าพบคีย์ตรงกัน ให้นำ text มาใช้
                        if (matchedFacility) {
                            $selectMainType.append($('<option>', {
                                value: key,
                                text: matchedFacility.text
                            }));
                        }
                    }
                }
            }

            $('#modal-select-main-type').modal('show');
        }
        else
        {
            showModal();
        }

    });


    $(document).on('click', '#button_select_main_type', function() {
        var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
        var selectedValue = $('#select_main_type').val(); // ดึงค่า value จาก select_main_type
        
        // ตรวจสอบว่า selectedValue มีค่าหรือไม่
        if (!selectedValue) {
            alert('กรุณาเลือกประเภทหลัก!');
            return; // หยุดการทำงานถ้าไม่มีค่า
        }
        
        var selectedText = $('#select_main_type option:selected').text(); // ดึงข้อความที่แสดงในตัวเลือกที่ถูกเลือก
        var scopes = lab_addresses_array[globalBranchNumber].lab_types[selectedValue];

        var lab_types = lab_addresses_array[globalBranchNumber].lab_types;

        for (var key in lab_types) {
            if (Array.isArray(lab_types[key]) || lab_types[key] == 1) {
                lab_types[key] = [...scopes]; // อัพเดทคีย์ให้เหมือนกับ scopes
            }
        }

        sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
        console.log('Updated lab_types:', lab_types); // ดูผลลัพธ์ของการอัพเดท
        $('#modal-select-main-type').modal('hide');
        showModal();
    });

    function showModal()
    {
        $('#lab_cal_scope_body').html('');
            var selectedValue = $('input[name="lab_ability"]:checked').val();
            const _token = $('input[name="_token"]').val();
            
            if (selectedValue === 'test') {
                alert('ของ test ยังบ่าได้ทำเตื่อ');
            } else if (selectedValue === 'calibrate') {
                $('#cal_instrument_wrapper').hide();
                $('#cal_parameter_one_wrapper').hide();
                $('#cal_parameter_two_wrapper').hide();
                $.ajax({
                        url:"{{route('api.calibrate')}}",
                        method:"POST",
                        data:{
                            _token:_token
                        },
                        success:function (result){
                            // ล้างค่าเดิมใน select element ก่อนเพิ่มค่าใหม่
                            $('#cal_main_branch').empty();
                            $('#cal_main_branch').append('<option value="" disabled selected>- สาขาสอบเทียบ -</option>');

                            $.each(result,function (index,value) {
                                $('#cal_main_branch').append('<option value='+value.id+' >'+value.title+'</option>')
                            });
                        }
                    });

                renderCalScopeTable(globalBranchNumber, globalTypeNumber);
                $('#modal-add-cal-scope').modal('show');
            }
    }


    $(document).on('change', '#cal_main_branch', function() {
        var bcertify_calibration_branche_id = $(this).val();
        const _token = $('input[name="_token"]').val();
        $('#cal_instrument_wrapper').hide();
        $('#cal_parameter_one_wrapper').hide();
        $('#cal_parameter_two_wrapper').hide();

        $.ajax({
            url: "{{route('api.instrumentgroup')}}",
            method: "POST",
            data: {
                bcertify_calibration_branche_id: bcertify_calibration_branche_id,
                _token: _token
            },
            success: function(result) {
                // console.log(result);

                // Clear selected value and options
                $('#cal_instrumentgroup').val(null).trigger('change'); // Clear selected value
                $('#cal_instrumentgroup').select2('destroy').empty(); // Destroy select2 instance and clear options

                // Reinitialize select2 with an empty option
                $('#cal_instrumentgroup').append('<option value="" disabled selected>- เลือกเครื่องมือ1 -</option>');
                
                $.each(result, function(index, value) {
                    $('#cal_instrumentgroup').append('<option value=' + value.id + '>' + value.name + '</option>');
                });

                // Reinitialize select2
                $('#cal_instrumentgroup').select2();
            }
        });
    });



    $(document).on('change', '#cal_instrumentgroup', function() {
        var calibration_branch_instrument_group_id = $(this).val();
        const _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{route('api.instrument_and_parameter')}}",
            method: "POST",
            data: {
                calibration_branch_instrument_group_id: calibration_branch_instrument_group_id,
                _token: _token
            },
            success: function (result) {
                // ตรวจสอบและแสดงหรือซ่อน wrapper ตามผลลัพธ์

                $('#cal_instrument').select2('destroy').empty();
                $('#cal_instrument').select2();

                $('#cal_parameter_one').select2('destroy').empty();
                $('#cal_parameter_one').select2();

                $('#cal_parameter_two').select2('destroy').empty();
                $('#cal_parameter_two').select2();

                if (result.instrument && result.instrument.length > 0) {
                    $('#cal_instrument_wrapper').show();

                    // Destroy and clear the select2 instance and options for #cal_instrument
                    // $('#cal_instrument').select2('destroy').empty();
                    $('#cal_instrument').append('<option value="" disabled selected>- เลือกเครื่องมือ -</option>');

                    $.each(result.instrument, function (index, value) {
                        $('#cal_instrument').append('<option value=' + value.id + '>' + value.name + '</option>');
                    });

                    // Reinitialize select2
                    // $('#cal_instrument').select2();
                } else {

                    $('#cal_instrument_wrapper').hide();
                }


                if (result.parameter_one && result.parameter_one.length > 0) {
                    $('#cal_parameter_one_wrapper').show();

                    // Destroy and clear the select2 instance and options for #cal_parameter_one
                    // $('#cal_parameter_one').select2('destroy').empty();
                    $('#cal_parameter_one').append('<option value="" disabled selected>- เลือกพารามิเตอร์1 -</option>');

                    $.each(result.parameter_one, function (index, value) {
                        $('#cal_parameter_one').append('<option value=' + value.id + '>' + value.name + '</option>');
                    });

                    // Reinitialize select2
                    // $('#cal_parameter_one').select2();
                } else {
                    $('#cal_parameter_one_wrapper').hide();
                }

                if (result.parameter_two && result.parameter_two.length > 0) {
                    $('#cal_parameter_two_wrapper').show();

                    // Destroy and clear the select2 instance and options for #cal_parameter_two
                    // $('#cal_parameter_two').select2('destroy').empty();
                    $('#cal_parameter_two').append('<option value="" disabled selected>- เลือกพารามิเตอร์2 -</option>');

                    $.each(result.parameter_two, function (index, value) {
                        $('#cal_parameter_two').append('<option value=' + value.id + '>' + value.name + '</option>');
                    });

                    // Reinitialize select2
                    // $('#cal_parameter_two').select2();
                } else {
                    $('#cal_parameter_two_wrapper').hide();
                }
            }
        });
    });


    $(document).on('click', '#button_add_scope', function() {
    
        if (typeof globalTypeNumber !== 'undefined' && typeof globalBranchNumber !== 'undefined') {

            var selectedValues = {
                cal_main_branch: $('#cal_main_branch').val() || '',
                cal_main_branch_text: $('#cal_main_branch').length ? $('#cal_main_branch option:selected').text() : '',
                
                cal_instrumentgroup: $('#cal_instrumentgroup').val() || '',
                cal_instrumentgroup_text: $('#cal_instrumentgroup').length ? $('#cal_instrumentgroup option:selected').text() : '',
                
                cal_instrument: $('#cal_instrument').val() || '',
                cal_instrument_text: $('#cal_instrument').length ? $('#cal_instrument option:selected').text() : '',
                
                cal_parameter_one: $('#cal_parameter_one').val() || '',
                cal_parameter_one_text: $('#cal_parameter_one').length ? $('#cal_parameter_one option:selected').text() : '',
                cal_parameter_one_value: '',
                
                cal_parameter_two: $('#cal_parameter_two').val() || '',
                cal_parameter_two_text: $('#cal_parameter_two').length ? $('#cal_parameter_two option:selected').text() : '',
                cal_parameter_two_value: '',
            };

            // ดึงข้อมูล array จาก sessionStorage
            var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

            if (lab_addresses_array[globalBranchNumber]) {
                if (!Array.isArray(lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'])) {
                    lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'] = [];
                }

                lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'].push(selectedValues);
            }

            sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
            console.log(lab_addresses_array);
            renderCalScopeTable(globalBranchNumber, globalTypeNumber);

        } else if (typeof globalTypeNumber === 'undefined' && typeof globalBranchNumber !== 'undefined') {
            var selectedValues = {
                cal_main_branch: $('#cal_main_branch').val() || '',
                cal_main_branch_text: $('#cal_main_branch').length ? $('#cal_main_branch option:selected').text() : '',
                
                cal_instrumentgroup: $('#cal_instrumentgroup').val() || '',
                cal_instrumentgroup_text: $('#cal_instrumentgroup').length ? $('#cal_instrumentgroup option:selected').text() : '',
                
                cal_instrument: $('#cal_instrument').val() || '',
                cal_instrument_text: $('#cal_instrument').length ? $('#cal_instrument option:selected').text() : '',
                
                cal_parameter_one: $('#cal_parameter_one').val() || '',
                cal_parameter_one_text: $('#cal_parameter_one').length ? $('#cal_parameter_one option:selected').text() : '',
                cal_parameter_one_value: '',
                
                cal_parameter_two: $('#cal_parameter_two').val() || '',
                cal_parameter_two_text: $('#cal_parameter_two').length ? $('#cal_parameter_two option:selected').text() : '',
                cal_parameter_two_value: '',
            };

            var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
            
            if (lab_addresses_array[globalBranchNumber]) {
                var lab_types = lab_addresses_array[globalBranchNumber].lab_types;
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key])) {
                        lab_types[key].push(selectedValues);
                    } else if (lab_types[key] === 1) {
                        // ถ้าค่าเป็น 0 หรือ 1 เปลี่ยนให้เป็น array ก่อนแล้วค่อยเพิ่ม selectedValues
                        lab_types[key] = [selectedValues];
                    }
                }
            }

            sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
            lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
            console.log(lab_addresses_array);
            renderCalScopeTable(globalBranchNumber, globalTypeNumber);
            // อัปเดตตารางสำหรับทุก type
            // for (var key in lab_addresses_array[globalBranchNumber].lab_types) {
            //     renderCalScopeTable(globalBranchNumber, key.replace('pl_2_', '').replace('_branch', ''));
            // }
        }
    });


    $(document).on('click', '#button_add_parameter_two', function() {
        var parameterTwoText = $('#parameter_two_textarea').val().trim();
        
        // ตรวจสอบว่ามีค่าใน parameterTwoText หรือไม่
        if (parameterTwoText !== '') {
            var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

            // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber มีค่าหรือไม่
            if (globalBranchNumber !== undefined && globalTypeNumber !== undefined && selectedScopeIndex !== undefined) {
                var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];

                // ตรวจสอบว่า selectedScopeIndex ตรงกับ index ของ scope ที่ต้องการหรือไม่
                var scope = scopes[selectedScopeIndex];
                // console.log(scope);
                if (scope) {
                    // ตรวจสอบว่ามีคีย์ cal_parameter_two_value อยู่แล้วหรือไม่ ถ้ามีให้เพิ่มข้อมูลใหม่เข้าไป
                    if (scope.cal_parameter_two_value !== undefined) {
                        scope.cal_parameter_two_value = parameterTwoText;  // อัปเดตค่าของ cal_parameter_two_value
                    }
                    console.log('====');
                    console.log(lab_addresses_array);
                    console.log('====');
                    // บันทึกกลับไปใน sessionStorage
                    sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));

                    // ปิด modal
                    $('#modal-add-parameter-two').modal('hide');

                    // อัปเดตตาราง
                    renderCalScopeTable(globalBranchNumber, globalTypeNumber);
                }
            }
        }
    });

    function renderCalScopeTable(branchNumber, typeNumber) {
        var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
        var scopes = null;

    // console.log('typeNumber ' + typeNumber)
        // ตรวจสอบว่า typeNumber เท่ากับ null หรือไม่
        if (typeNumber === undefined) {
            console.log('aha');
            var lab_types = lab_addresses_array[branchNumber].lab_types;
            
            // ค้นหาคีย์แรกที่มีค่าไม่เท่ากับ 0 และเป็น array
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                    scopes = lab_types[key];
                    break;
                }
            }
            console.log(scopes);
        } else if (lab_addresses_array[branchNumber] && Array.isArray(lab_addresses_array[branchNumber].lab_types['pl_2_' + typeNumber + '_branch'])) {
            // กรณี typeNumber ไม่ใช่ null และเป็น array ที่ต้องการ
            scopes = lab_addresses_array[branchNumber].lab_types['pl_2_' + typeNumber + '_branch'];
        }

        if (scopes) {
            // ล้างตารางก่อนเติมข้อมูลใหม่
            $('#lab_cal_scope_body').empty();

            // จัดเรียงข้อมูลตาม cal_main_branch (โดยถือว่า cal_main_branch เป็นค่า ID หรือตัวเลข)
            scopes.sort(function(a, b) {
                return a.cal_main_branch - b.cal_main_branch;
            });

            // วนลูปเพื่อสร้างแถวใหม่ในตาราง
            scopes.forEach(function(scope, index) { // เพิ่ม index ตรงนี้
                var parameterOneButton = '';
                var parameterTwoButton = '';
                var parameterOneValue = '';
                var parameterTwoValue = '';

                // ตรวจสอบว่า scope.cal_parameter_one_text ไม่ใช่ค่าว่าง
                if (scope.cal_parameter_one_text !== '') {
                    parameterOneButton = `<button type="button" class="btn btn-info btn-xs btn-add-items-parameter-one" data-index="${index}">
                                            <i class="fa fa-plus"></i>
                                        </button>`;
                }

                // ตรวจสอบว่า scope.cal_parameter_two_text ไม่ใช่ค่าว่าง
                if (scope.cal_parameter_two_text !== '') {
                    parameterTwoButton = `<button type="button" class="btn btn-info btn-xs btn-add-items-parameter-two" data-index="${index}">
                                            <i class="fa fa-plus"></i>
                                        </button>`;
                }

                if (scope.cal_parameter_one_value !== '') {
                    parameterOneValue = `${scope.cal_parameter_one_value}`;
                }

                if (scope.cal_parameter_two_value !== '') {
                    parameterTwoValue = `${scope.cal_parameter_two_value}`;
                }

                var newRow = `<tr>
                    <td>${scope.cal_main_branch_text}</td>
                    <td>${scope.cal_instrumentgroup_text}</td>
                    <td>${scope.cal_instrument_text}</td>
                    <td>${scope.cal_parameter_one_text} ${parameterOneButton} ${parameterOneValue}</td>
                    <td>${scope.cal_parameter_two_text} ${parameterTwoButton} ${parameterTwoValue}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs btn-delete-scope-row" data-index="${index}">
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>
                </tr>`;

                $('#lab_cal_scope_body').append(newRow);
            });
        }
    }


    $(document).on('click', '.btn-delete-scope-row', function() {

        // หาค่า index ของแถวที่ต้องการลบ
        var rowIndex = $(this).closest('tr').index();

        // ดึงข้อมูล array จาก sessionStorage
        var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

        if (typeof globalTypeNumber !== 'undefined') {
            // ตรวจสอบว่า lab_addresses_array และ scopes มีข้อมูลอยู่หรือไม่
            if (lab_addresses_array[globalBranchNumber] && Array.isArray(lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'])) {
                var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];

                // ลบรายการที่เลือกจาก array
                scopes.splice(rowIndex, 1);
                
                // บันทึก array กลับไปที่ session storage
                sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
                
                // เรียกใช้ฟังก์ชันเพื่ออัปเดตตาราง
                renderCalScopeTable(globalBranchNumber, globalTypeNumber);
            }
        } else {
            // กรณีที่ globalTypeNumber เป็น undefined
            if (lab_addresses_array[globalBranchNumber]) {
                var lab_types = lab_addresses_array[globalBranchNumber].lab_types;
                
                // ลบรายการจากทุก lab_types ที่ไม่เท่ากับ 0 และเป็น array
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key])) {
                        lab_types[key].splice(rowIndex, 1);
                    }
                }

                // บันทึก array กลับไปที่ session storage
                sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
                renderCalScopeTable(globalBranchNumber, globalTypeNumber);

            }
        }
    });


    $(document).on('click', '.btn-add-items-parameter-one', function() {
        // เก็บค่า data-index จากปุ่มที่ถูกกด
        selectedScopeIndex = $(this).data('index');


        var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
        var parameterOneValue = '';

        // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber ไม่เท่ากับ undefined
        if (typeof globalBranchNumber !== 'undefined' && typeof globalTypeNumber !== 'undefined') {
            // ดึงค่า scopes จาก lab_addresses_array ตาม globalBranchNumber และ globalTypeNumber
            var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];

            // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_parameter_one_value
            if (scopes && scopes[selectedScopeIndex]) {
                parameterOneValue = scopes[selectedScopeIndex].cal_parameter_one_value || '';
            }
        } else if (typeof globalBranchNumber !== 'undefined') {
            // ค้นหา lab_types แรกที่ไม่เท่ากับ 0 และเป็น array
            var lab_types = lab_addresses_array[globalBranchNumber].lab_types;
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                    var scopes = lab_types[key];

                    // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_parameter_one_value
                    if (scopes && scopes[selectedScopeIndex]) {
                        parameterOneValue = scopes[selectedScopeIndex].cal_parameter_one_value || '';
                        break;
                    }
                }
            }
        }

        // อัปเดตค่าใน Summernote editor
        $('#parameter_one_textarea').summernote('code', parameterOneValue);


        // แสดง modal
        $('#modal-add-parameter-one').modal('show');
    });


    $(document).on('click', '.btn-add-items-parameter-two', function() {
        // เก็บค่า data-index จากปุ่มที่ถูกกด
        $('#parameter_two_textarea').val('');
        selectedScopeIndex = $(this).data('index');
        console.log(selectedScopeIndex);

        var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
        var parameterTwoValue = '';

        // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber ไม่เท่ากับ undefined
        if (typeof globalBranchNumber !== 'undefined' && typeof globalTypeNumber !== 'undefined') {
            // ดึงค่า scopes จาก lab_addresses_array ตาม globalBranchNumber และ globalTypeNumber
            var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];

            // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_parameter_two_value
            if (scopes && scopes[selectedScopeIndex]) {
                parameterTwoValue = scopes[selectedScopeIndex].cal_parameter_two_value || '';
            }
        } else if (typeof globalBranchNumber !== 'undefined') {
            // ค้นหา lab_types แรกที่ไม่เท่ากับ 0 และเป็น array
            var lab_types = lab_addresses_array[globalBranchNumber].lab_types;
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                    var scopes = lab_types[key];

                    // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_parameter_two_value
                    if (scopes && scopes[selectedScopeIndex]) {
                        parameterTwoValue = scopes[selectedScopeIndex].cal_parameter_two_value || '';
                        break;
                    }
                }
            }
        }

        $('#parameter_two_textarea').summernote('code', parameterTwoValue);

        $('#modal-add-parameter-two').modal('show');
    });

    $(document).on('click', '#button_add_parameter_one', function() {
        var parameterOneText = $('#parameter_one_textarea').val().trim();

        // ตรวจสอบว่ามีค่าใน parameterOneText หรือไม่
        if (parameterOneText !== '') {
            var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

            // ตรวจสอบว่า globalBranchNumber มีค่าอยู่หรือไม่
            if (typeof globalBranchNumber !== 'undefined' && typeof selectedScopeIndex !== 'undefined') {
                // ตรวจสอบว่า globalTypeNumber เท่ากับ undefined หรือไม่
                if (typeof globalTypeNumber === 'undefined') {
                    var lab_types = lab_addresses_array[globalBranchNumber].lab_types;

                    // ค้นหาและอัปเดตเฉพาะรายการใน lab_types ที่เป็น array และไม่เท่ากับ 0
                    for (var key in lab_types) {
                        if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                            var scope = lab_types[key][selectedScopeIndex];
                            if (scope && scope.cal_parameter_one_value !== undefined) {
                                scope.cal_parameter_one_value = parameterOneText; // อัปเดตค่าของ cal_parameter_one_value
                            }
                        }
                    }
                } else {
                    var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];
                    var scope = scopes[selectedScopeIndex];
                    if (scope && scope.cal_parameter_one_value !== undefined) {
                        scope.cal_parameter_one_value = parameterOneText; // อัปเดตค่าของ cal_parameter_one_value
                    }
                }

                // บันทึกกลับไปใน sessionStorage
                sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));

                // ปิด modal
                $('#modal-add-parameter-one').modal('hide');

                // อัปเดตตาราง
                renderCalScopeTable(globalBranchNumber, globalTypeNumber);
            }
        }
    });


    $(document).on('click', '#button_add_parameter_two', function() {
        var parameterTwoText = $('#parameter_two_textarea').val().trim();

        // ตรวจสอบว่ามีค่าใน parameterTwoText หรือไม่
        if (parameterTwoText !== '') {
            var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

            // ตรวจสอบว่า globalBranchNumber มีค่าอยู่หรือไม่
            if (typeof globalBranchNumber !== 'undefined' && typeof selectedScopeIndex !== 'undefined') {
                // ตรวจสอบว่า globalTypeNumber เท่ากับ undefined หรือไม่
                if (typeof globalTypeNumber === 'undefined') {
                    var lab_types = lab_addresses_array[globalBranchNumber].lab_types;

                    // ค้นหาและอัปเดตเฉพาะรายการใน lab_types ที่เป็น array และไม่เท่ากับ 0
                    for (var key in lab_types) {
                        if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                            var scope = lab_types[key][selectedScopeIndex];
                            if (scope && scope.cal_parameter_two_value !== undefined) {
                                scope.cal_parameter_two_value = parameterTwoText; // อัปเดตค่าของ cal_parameter_two_value
                            }
                        }
                    }
                } else {
                    var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];
                    var scope = scopes[selectedScopeIndex];
                    if (scope && scope.cal_parameter_two_value !== undefined) {
                        scope.cal_parameter_two_value = parameterTwoText; // อัปเดตค่าของ cal_parameter_two_value
                    }
                }

                // บันทึกกลับไปใน sessionStorage
                sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));

                // ปิด modal
                $('#modal-add-parameter-two').modal('hide');

                // อัปเดตตาราง
                renderCalScopeTable(globalBranchNumber, globalTypeNumber);
            }
        }
    });


    // ใช้ event delegation สำหรับ checkbox
    $(document).on('change', '.lab-scope-checkbox', function() {
        var isChecked = $(this).is(':checked');
        var typesContainer = $(this).closest('tr').find('.types-container');
        var branch_id = $(this).data('branch');
        // console.log('branch ' + branch_id);
        var lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

        if (isChecked) {
            // ซ่อนปุ่มประเภทและแสดงปุ่ม "เพิ่มขอบข่ายร่วม"
            typesContainer.html(`<a class="btn btn-primary btn-xs add-lab-scope data-type="" data-branch="${branch_id}">เพิ่มขอบข่ายร่วม</a>`);
        } else {
            // แสดงปุ่มประเภทตามปกติ
            var address = lab_addresses_array[branch_id];
            var typesHtml = '';

            if (address.lab_types.pl_2_1_branch) {
                typesHtml += `<a class="btn btn-primary btn-xs add-lab-scope" data-type="1" data-branch="${branch_id}">ประเภท 1</a> `;
            }
            if (address.lab_types.pl_2_2_branch) {
                typesHtml += `<a class="btn btn-success btn-xs add-lab-scope" data-type="2" data-branch="${branch_id}">ประเภท 2</a> `;
            }
            if (address.lab_types.pl_2_3_branch) {
                typesHtml += `<a class="btn btn-info btn-xs add-lab-scope" data-type="3" data-branch="${branch_id}">ประเภท 3</a> `;
            }
            if (address.lab_types.pl_2_4_branch) {
                typesHtml += `<a class="btn btn-warning btn-xs add-lab-scope" data-type="4" data-branch="${branch_id}">ประเภท 4</a> `;
            }
            if (address.lab_types.pl_2_5_branch) {
                typesHtml += `<a class="btn btn-danger btn-xs add-lab-scope" data-type="5" data-branch="${branch_id}">ประเภท 5</a> `;
            }

            typesContainer.html(typesHtml);
        }
    });

    function countChecked() {
        let count = 0;

        $(".check_main").each(function(){
            // ข้าม checkbox ที่เป็นตัวเอง
            if (this !== event.target) {
                if ($(this).is(':checked')) {
                    count++;
                }
            }
        });

        return count;
    }


    $(document).on('change', '#checkbox_main', function() {
        var isChecked = $(this).is(':checked');
        var mainTypesContainer = $('#main-branch-container');
        console.log(isChecked);
        if(isChecked){
            mainTypesContainer.html(`<a class="btn btn-primary btn-xs add-main-lab-scope data-type="" data-branch="">เพิ่มขอบข่ายร่วม</a>`);
        }else{

            var typesHtml = '';
            for (var i = 1; i <= 5; i++) {
                var checkboxId = '#pl_2_' + i;
                var buttonClass = buttonColors[i - 1];
                var buttonText = 'ประเภท ' + i;

                if ($(checkboxId).is(':checked')) {
                    // typesHtml += `<a class="btn ${buttonClass} btn-xs add-lab-scope" data-type="${i}" data-branch="">${buttonText}</a> `;
                    typesHtml += `<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="">${buttonText}</a>`;
                }
            }
            mainTypesContainer.html(typesHtml);
        }
    });


    for (var i = 1; i <= 5; i++) {
        (function(i) {
            var checkboxId = '#pl_2_' + i;
            var buttonClass = buttonColors[i - 1];
            
            // Fetch the existing lab_main_address from storage or initialize it
            var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };

            $(checkboxId).on("ifChanged", function(event){
                var isChecked = $(this).prop('checked');
                var mainTypesContainer = $('#main-branch-container');
                var checkboxMainBranchContainer = $('#checkbox-main-branch-container');

                let checkedCount = countChecked();

                if (checkedCount === 1) {
                    // เพิ่ม <div> เข้าไปใน #checkbox-main-branch-container
                    if (checkboxMainBranchContainer.find('div.checkbox-success').length === 0) {
                        checkboxMainBranchContainer.append(`
                            <div class="checkbox checkbox-success">
                                <input id="checkbox_main" type="checkbox" data-branch="" >
                                <label for="checkbox_main">
                                    <span class="font-16"></span>
                                </label>
                            </div>
                        `);
                    }

                    if (isChecked) {
                        if (mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).length === 0) {
                            mainTypesContainer.append(`<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="">ประเภท ${i}</a>`);
                        }
                    } else {
                        mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
                    }
                } 
                else if (checkedCount === 0) {
                    checkboxMainBranchContainer.find('div.checkbox-success').remove();
                    mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
                } else {
                    var checkboxMain = $('#checkbox_main');
                    if (checkboxMain.is(':checked')) {
                        console.log('checkbox_main is checked');
                        mainTypesContainer.html(`<a class="btn btn-primary btn-xs add-main-lab-scope" data-type="" data-branch="">เพิ่มขอบข่ายร่วม</a>`);
                    } else {
                        if (isChecked) {
                            if (mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).length === 0) {
                                mainTypesContainer.append(`<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="">ประเภท ${i}</a>`);
                            }
                        } else {
                            mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
                        }
                    }
                }

                // Update lab_main_address based on the checkbox state
                var existingValue = lab_main_address.lab_types['pl_2_' + i + '_main'];
                var newValue = isChecked ? (Array.isArray(existingValue) ? existingValue : 1) : 0;
                lab_main_address.lab_types['pl_2_' + i + '_main'] = newValue;

                // Save the updated lab_main_address to sessionStorage
                sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
                console.log(lab_main_address);
            });
        })(i);
    }


    // for (var i = 1; i <= 5; i++) {
    //     (function(i) {
    //         var checkboxId = '#pl_2_' + i;
    //         var buttonClass = buttonColors[i - 1];

    //         $(checkboxId).on("ifChanged", function(event){
    //             var isChecked = $(this).prop('checked');
    //             var mainTypesContainer = $('#main-branch-container');
    //             var checkboxMainBranchContainer = $('#checkbox-main-branch-container');
            
    //             let checkedCount = countChecked();

    //             if (checkedCount === 1) {
    //                 // เพิ่ม <div> เข้าไปใน #checkbox-main-branch-container
    //                 if (checkboxMainBranchContainer.find('div.checkbox-success').length === 0) {
    //                     checkboxMainBranchContainer.append(`
    //                         <div class="checkbox checkbox-success">
    //                             <input id="checkbox_main" type="checkbox" data-branch="" >
    //                             <label for="checkbox_main">
    //                                 <span class="font-16"></span>
    //                             </label>
    //                         </div>
    //                     `);
    //                 }

    //                 if (isChecked) {
    //                     if (mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).length === 0) {
    //                         mainTypesContainer.append(`<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="">ประเภท ${i}</a>`);
    //                     }
    //                 } else {
    //                     mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
    //                 }
    //             } 
    //             else if (checkedCount === 0) {
    //                 checkboxMainBranchContainer.find('div.checkbox-success').remove();
    //                 mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
    //             } else {
                    
    //                 var checkboxMain = $('#checkbox_main');
    //                 if (checkboxMain.is(':checked')) {
    //                     console.log('checkbox_main is checked');
    //                     mainTypesContainer.html(`<a class="btn btn-primary btn-xs add-main-lab-scope" data-type="" data-branch="">เพิ่มขอบข่ายร่วม</a>`);
    //                 } else {
    //                     if (isChecked) {
    //                         if (mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).length === 0) {
    //                             mainTypesContainer.append(`<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="">ประเภท ${i}</a>`);
    //                         }
    //                     } else {
    //                         mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
    //                     }
    //                 }
    //             }
    //         });
    //     })(i);
    // }


}