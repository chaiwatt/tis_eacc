

var baseUrl = $('meta[name="base-url"]').attr('content') + '/';
var globalTypeNumber = null;
var globalBranchNumber = null;
var globalBranchOffice = 'main';
var selectedScopeIndex;
var buttonColors = ['btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-danger'];
var lab_main_address;
var lab_branch_address;
var lab_addresses_array;

var attach_path;
let measurements = [];
let lab_cal_scope_data_transaction = []; // อาร์เรย์เก็บข้อมูลทั้งหมด

let test_measurements = [];
let lab_test_scope_data_transaction = []; // อาร์เรย์เก็บข้อมูลทั้งหมด

const facilityTypes = {
    'pl_2_1': 'สถานปฏิบัติการถาวร (Permanent facilities)',
    'pl_2_2': 'สถานปฏิบัติการนอกสถานที่ (Sites away from its permanent facilities)',
    'pl_2_3': 'สถานปฏิบัติการเคลื่อนที่ (Mobile facilities)',
    'pl_2_4': 'สถานปฏิบัติการชั่วคราว (Temporary facilities)',
    'pl_2_5': 'สถานปฏิบัติการหลายสถานที่ (Multi-site facilities)',
};

var branchFacilityTypes = [
    { text: "ประเภท1 สถานปฏิบัติการถาวร (Permanent facilities)", id: "pl_2_1_branch" },
    { text: "ประเภท2 สถานปฏิบัติการนอกสถานที่ (Sites away from its permanent facilities)", id: "pl_2_2_branch" },
    { text: "ประเภท3 สถานปฏิบัติการเคลื่อนที่ (Mobile facilities)", id: "pl_2_3_branch" },
    { text: "ประเภท4 สถานปฏิบัติการชั่วคราว (Temporary facilities)", id: "pl_2_4_branch" },
    { text: "ประเภท5 สถานปฏิบัติการหลายสถานที่ (Multi-site facilities)", id: "pl_2_5_branch" }
];

var mainFacilityTypes = [
    { text: "ประเภท1 สถานปฏิบัติการถาวร (Permanent facilities)", id: "pl_2_1_main" },
    { text: "ประเภท2 สถานปฏิบัติการนอกสถานที่ (Sites away from its permanent facilities)", id: "pl_2_2_main" },
    { text: "ประเภท3 สถานปฏิบัติการเคลื่อนที่ (Mobile facilities)", id: "pl_2_3_main" },
    { text: "ประเภท4 สถานปฏิบัติการชั่วคราว (Temporary facilities)", id: "pl_2_4_main" },
    { text: "ประเภท5 สถานปฏิบัติการหลายสถานที่ (Multi-site facilities)", id: "pl_2_5_main" }
];

$(document).ready(function () {


    $('#parameter_one_textarea').summernote({
        height: 150, // กำหนดความสูงของ textarea
        toolbar: [
            ['para', ['ul', 'ol', 'paragraph']], // เพิ่มเฉพาะเครื่องมือที่ต้องการ
        ]
    });

    $('#parameter_two_textarea').summernote({
        height: 150, // กำหนดความสูงของ textarea
        toolbar: [
            ['para', ['ul', 'ol', 'paragraph']], // เพิ่มเฉพาะเครื่องมือที่ต้องการ
        ]
    });

    $('#cal_method_textarea').summernote({
        height: 200, // กำหนดความสูงของ textarea
        toolbar: [
            ['para', ['ul', 'ol', 'paragraph']], // เพิ่มเฉพาะเครื่องมือที่ต้องการ
        ]
    });




    

    $('#lab_addresses_input').val('');
    $('#lab_main_address_input').val('');
    currentMethod = 'edit';
    if(currentMethod === "create"){
        console.log("หน้า create ต้องสร้าง createLabMainAddressStorage จากข้อมูลเปล่า")
        branchLabAdresses = [];
        sessionStorage.removeItem('lab_addresses_array');
        createLabMainAddressStorage();
        // console.log(lab_main_address)
        // console.log(lab_branch_address)
    // }else if(currentMethod === "edit" || currentMethod === "show"){
    }else {

        console.log("หน้า edit ต้องสร้าง createLabMainAddressStorage จากฐานข้อมูลนะ")

        console.log('labRequestMain',labRequestMain);
        console.log('labRequestBranchs',labRequestBranchs);
        console.log('certi_lab type',labRequestMain.certi_lab.lab_type);

        if (labRequestMain) {
            if (labRequestMain.certi_lab.lab_type == 3){
                console.log("LAB test")

                const lab_main_address_server = {
                    lab_type: 'main',
                    checkbox_main: '1',
                    address_number_add: labRequestMain.no || "",
                    village_no_add: labRequestMain.moo || "",
                    address_soi_add: labRequestMain.soi || "",
                    address_street_add: labRequestMain.street || "",
                    address_city_add: labRequestMain.province_id || "",
                    address_city_text_add: labRequestMain.province_name || "",
                    address_district_add: labRequestMain.amphur_name || "",
                    sub_district_add: labRequestMain.tambol_name || "",
                    postcode_add: labRequestMain.postal_code || "",
                    lab_address_no_eng_add: labRequestMain.no_eng || "",
                    lab_province_text_eng_add: labRequestMain.province_name_eng || "",
                    lab_province_eng_add: labRequestMain.province_id || "",
                    lab_amphur_eng_add: labRequestMain.amphur_name_eng || "",
                    lab_district_eng_add: labRequestMain.tambol_name_eng || "",
                    lab_moo_eng_add: labRequestMain.moo_eng || "",
                    lab_soi_eng_add: labRequestMain.soi_eng || "",
                    lab_street_eng_add: labRequestMain.street_eng || "",
                    amphur_id_add: labRequestMain.amphur_id || "",
                    tambol_id_add: labRequestMain.tambol_id || "",
                    lab_types: createLabTestRequestFromServer(labRequestMain, null, "main"), // เรียกใช้ฟังก์ชันเพื่อสร้าง lab_types

                };
                
   
                sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address_server));
                lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address'));

                var typesHtml = '';
                labTypes = lab_main_address.lab_types;
                Object.keys(labTypes).forEach((key, index) => {
                    var value = labTypes[key];
                    if (Array.isArray(value)) { // ตรวจสอบว่าเป็น Array หรือไม่
                        var buttonText = 'ประเภท ' + (index + 1);
                        var tooltipText = 'รายการประเภท ' + (index + 1); // กำหนดข้อความ tooltip
                        var buttonClass = buttonColors[index]; 
                
                        typesHtml += `<a class="btn ${buttonClass} btn-xs add-lab-main-scope" 
                            style="margin-left:2px !important; margin-right:2px !important" 
                            data-type="${index + 1}" 
                            title="${tooltipText}">
                                ${buttonText}
                            </a>`;
                    }
                });

                if(currentMethod === "edit"){
                    document.getElementById("main-branch-container").innerHTML = typesHtml;
                }
                

                

                const lab_addresses_array_servers = [];
                labRequestBranchs.forEach(branch => {
                   
                    lab_addresses_array_servers.push({
                        lab_type: 'branch',
                        checkbox_branch: '1',
                        address_number_add_modal: branch.no || "",
                        village_no_add_modal: branch.moo || "",
                        soi_add_modal: branch.soi || "",
                        road_add_modal: branch.street || "",
                        // จังหวัด
                        address_city_add_modal: branch.province_id || "",
                        address_city_text_add_modal: branch.province_name || "",
                        // อำเภอ
                        address_district_add_modal: branch.amphur_name || "",
                        address_district_add_modal_id: branch.amphur_id || "",
                        // ตำบล
                        sub_district_add_modal: branch.tambol_name || "",
                        sub_district_add_modal_id: branch.tambol_id || "",
                        // รหัสไปรษณีย์
                        postcode_add_modal: branch.postal_code || "",
                
                        // eng
                        lab_address_no_eng_add_modal: branch.no_eng || "",
                        lab_moo_eng_add_modal: branch.moo_eng || "",
                        lab_soi_eng_add_modal: branch.soi_eng || "",
                        lab_street_eng_add_modal: branch.street_eng || "",
                
                        lab_province_eng_add_modal: branch.province_name_eng || "",
                        // อำเภอ
                        lab_amphur_eng_add_modal: branch.amphur_name_eng || "",
                        // ตำบล
                        lab_district_eng_add_modal: branch.tambol_name_eng || "",
                
                        lab_types: createLabTestRequestFromServer(branch, null, "branch"), // เรียกใช้ฟังก์ชันเพื่อสร้าง lab_types สำหรับสาขา
                    });
                });

                sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array_servers));

                // ดึงข้อมูลจาก session storage เมื่อเอกสารถูกโหลด
                lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

                console.log('lab_addresses_array',lab_addresses_array);
                
                renderTestScopeWithParameterTable();

                // ถ้ามีข้อมูลใน session storage ให้ render ในตาราง
                if (lab_addresses_array.length > 0) {
                    renderTable(lab_addresses_array);
                }

                // console.log('lab_main_address',lab_main_address.lab_types)
                
            }else if(labRequestMain.certi_lab.lab_type == 4){
                console.log("LAB cal")
                // สำนักงานใหญ่
                const lab_main_address_server = {
                    lab_type: 'main',
                    checkbox_main: '1',
                    address_number_add: labRequestMain.no || "",
                    village_no_add: labRequestMain.moo || "",
                    address_soi_add: labRequestMain.soi || "",
                    address_street_add: labRequestMain.street || "",
                    address_city_add: labRequestMain.province_id || "",
                    address_city_text_add: labRequestMain.province_name || "",
                    address_district_add: labRequestMain.amphur_name || "",
                    sub_district_add: labRequestMain.tambol_name || "",
                    postcode_add: labRequestMain.postal_code || "",
                    lab_address_no_eng_add: labRequestMain.no_eng || "",
                    lab_province_text_eng_add: labRequestMain.province_name_eng || "",
                    lab_province_eng_add: labRequestMain.province_id || "",
                    lab_amphur_eng_add: labRequestMain.amphur_name_eng || "",
                    lab_district_eng_add: labRequestMain.tambol_name_eng || "",
                    lab_moo_eng_add: labRequestMain.moo_eng || "",
                    lab_soi_eng_add: labRequestMain.soi_eng || "",
                    lab_street_eng_add: labRequestMain.street_eng || "",
                    amphur_id_add: labRequestMain.amphur_id || "",
                    tambol_id_add: labRequestMain.tambol_id || "",
                    lab_types: createLabCalRequestFromServer(labRequestMain, null, "main"), // เรียกใช้ฟังก์ชันเพื่อสร้าง lab_types

                };
    
                sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address_server));
                lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address'));
                console.log('lab_main_address',lab_main_address.lab_types)

                var typesHtml = '';
                labTypes = lab_main_address.lab_types;
                Object.keys(labTypes).forEach((key, index) => {
                    var value = labTypes[key];
                    if (Array.isArray(value)) { // ตรวจสอบว่าเป็น Array หรือไม่
                        var buttonText = 'ประเภท ' + (index + 1);
                        var tooltipText = 'รายการประเภท ' + (index + 1); // กำหนดข้อความ tooltip
                        var buttonClass = 'btn-success'; // คลาสของปุ่ม
                
                        typesHtml += `<a class="btn ${buttonClass} btn-xs add-lab-main-scope" 
                            style="margin-left:2px !important; margin-right:2px !important" 
                            data-type="${index + 1}" 
                            title="${tooltipText}">
                                ${buttonText}
                            </a>`;
                    }
                });


                if(currentMethod === "edit"){
                    document.getElementById("main-branch-container").innerHTML = typesHtml;
                }

                const lab_addresses_array_servers = [];
                labRequestBranchs.forEach(branch => {
                   
                    lab_addresses_array_servers.push({
                        lab_type: 'branch',
                        checkbox_branch: '1',
                        address_number_add_modal: branch.no || "",
                        village_no_add_modal: branch.moo || "",
                        soi_add_modal: branch.soi || "",
                        road_add_modal: branch.street || "",
                        // จังหวัด
                        address_city_add_modal: branch.province_id || "",
                        address_city_text_add_modal: branch.province_name || "",
                        // อำเภอ
                        address_district_add_modal: branch.amphur_name || "",
                        address_district_add_modal_id: branch.amphur_id || "",
                        // ตำบล
                        sub_district_add_modal: branch.tambol_name || "",
                        sub_district_add_modal_id: branch.tambol_id || "",
                        // รหัสไปรษณีย์
                        postcode_add_modal: branch.postal_code || "",
                
                        // eng
                        lab_address_no_eng_add_modal: branch.no_eng || "",
                        lab_moo_eng_add_modal: branch.moo_eng || "",
                        lab_soi_eng_add_modal: branch.soi_eng || "",
                        lab_street_eng_add_modal: branch.street_eng || "",
                
                        lab_province_eng_add_modal: branch.province_name_eng || "",
                        // อำเภอ
                        lab_amphur_eng_add_modal: branch.amphur_name_eng || "",
                        // ตำบล
                        lab_district_eng_add_modal: branch.tambol_name_eng || "",
                
                        lab_types: createLabCalRequestFromServer(branch, null, "branch"), // เรียกใช้ฟังก์ชันเพื่อสร้าง lab_types สำหรับสาขา
                    });
                });
                

                sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array_servers));

                // ดึงข้อมูลจาก session storage เมื่อเอกสารถูกโหลด
                lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

                console.log('lab_addresses_array',lab_addresses_array);

                renderCalScopeWithParameterTable();

                // ถ้ามีข้อมูลใน session storage ให้ render ในตาราง
                if (lab_addresses_array.length > 0) {
                    renderTable(lab_addresses_array);
                }
            }
        }

        // // console.log(labCalScopeTransactions.filter(item => item.branch_lab_adress_id === null));
        // const labCalScopeMainTransactions = labCalScopeTransactions.filter(item => item.branch_lab_adress_id === null);
        //     const lab_main_address_server = {
        //         lab_type: 'main',
        //         checkbox_main: '1',
        //         address_number_add: "",
        //         village_no_add: "",
        //         address_city_add: "",
        //         address_city_text_add: "",
        //         address_district_add: "",
        //         sub_district_add: "",
        //         postcode_add: "",
        //         lab_address_no_eng_add: "",
        //         lab_province_text_eng_add: "",
        //         lab_province_eng_add: "",
        //         lab_amphur_eng_add: "",
        //         lab_district_eng_add: "",
        //         lab_moo_eng_add: "",
        //         lab_soi_eng_add: "",
        //         lab_street_eng_add: "",
        //         lab_types: createLabTypesFromServer(labCalScopeMainTransactions,null,"main"), // เรียกใช้ฟังก์ชันเพื่อสร้าง lab_types
        //         address_soi_add: "",
        //         address_street_add: ""
        //     };

        //     lab_main_address = lab_main_address_server;

        //     console.log(lab_main_address);

        //     sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address_server));

        //     checkAllCheckboxes();

        //     lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address'));
        //     console.log('after load from server');
        //     console.log(lab_main_address);

        //     const labCalScopeBranchTransactions  = labCalScopeTransactions.filter(item => item.branch_lab_adress_id !== null);

        //     const branchAddresses = [];
        //     console.log(branchLabAdresses);
        //     branchLabAdresses.forEach(branchItem => {
        //         // console.log('branchItem.postal');
        //         // console.log(branchItem.postal);
        //         const lab_branch_address_server = {
        //             lab_type: 'branch',
        //             checkbox_main: '1',

        //             // thai
        //             address_number_add_modal: branchItem.addr_no || "",
        //             village_no_add_modal: branchItem.addr_moo || "",
        //             soi_add_modal: branchItem.addr_soi || "",
        //             road_add_modal: branchItem.addr_road || "",
                   
        //             // จังหวัด
        //             address_city_add_modal: branchItem.province.PROVINCE_ID || "",
        //             address_city_text_add_modal: branchItem.province.PROVINCE_NAME || "",
        //             // อำเภอ
        //             address_district_add_modal: branchItem.amphur.AMPHUR_NAME || "",
        //             address_district_add_modal_id: branchItem.amphur.AMPHUR_ID || "",
        //             // ตำบล
        //             sub_district_add_modal: branchItem.district.DISTRICT_NAME || "",
        //             sub_district_add_modal_id: branchItem.district.DISTRICT_ID || "",
        //             // รหัสไปรษณีย์
        //             postcode_add_modal: branchItem.postal || "",

        //             // eng
        //             lab_address_no_eng_add_modal: branchItem.addr_no || "",
        //             lab_moo_eng_add_modal: branchItem.addr_moo_en || "",
        //             lab_soi_eng_add_modal: branchItem.addr_soi_en || "",
        //             lab_street_eng_add_modal: branchItem.addr_road_en || "",

        //             lab_province_eng_add_modal: branchItem.province.PROVINCE_ID || "",
        //             // อำเภอ
        //             lab_amphur_eng_add_modal: branchItem.amphur.AMPHUR_NAME_EN || "",
        //             // ตำบล
        //             lab_district_eng_add_modal: branchItem.district.DISTRICT_NAME_EN || "",
                   
        //             lab_types: createLabTypesFromServer(labCalScopeBranchTransactions, branchItem.id, "branch"), // สำหรับสาขา
        //         };

        //         branchAddresses.push(lab_branch_address_server);
                       
        //     });

        //     sessionStorage.setItem('lab_addresses_array', JSON.stringify(branchAddresses));

        //     // ดึงข้อมูลจาก session storage เมื่อเอกสารถูกโหลด
        //     lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

        //     console.log('lab_addresses_array loaded');            
        //     console.log(lab_addresses_array);

        //     // ถ้ามีข้อมูลใน session storage ให้ render ในตาราง
        //     if (lab_addresses_array.length > 0) {
        //         renderTable(lab_addresses_array);
        //     }
                    
            

        }
});

function createLabCalRequestFromServer(serverData, branch_index, type) {
    // กำหนดโครงสร้างพื้นฐานของ labTypes
    let labTypes = {};
   
    // กำหนดค่าเริ่มต้นของ labTypes ตามประเภท (main หรือ branch) เป็น 0
    if (type === 'main') {
        labTypes = {
            pl_2_1_main: 0, // index 0
            pl_2_2_main: 0, // index 1
            pl_2_3_main: 0, // index 2
            pl_2_4_main: 0, // index 3
            pl_2_5_main: 0  // index 4
        };
    } else if (type === 'branch') {
        labTypes = {
            pl_2_1_branch: 0, // index 0
            pl_2_2_branch: 0, // index 1
            pl_2_3_branch: 0, // index 2
            pl_2_4_branch: 0, // index 3
            pl_2_5_branch: 0  // index 4
        };
    }
    
    // ตรวจสอบและเพิ่มข้อมูลจาก serverData.lab_cal_transactions
    if (serverData && Array.isArray(serverData.lab_cal_transactions)) {
        serverData.lab_cal_transactions.forEach(transaction => {
            const key = transaction.key; // ใช้ key จาก transaction เพื่อระบุตำแหน่งใน labTypes

            // ตรวจสอบว่า key มีอยู่ใน labTypes หรือไม่
            if (labTypes[key] !== undefined) {
                // สร้าง transactionData
                const transactionData = {
                    index: transaction.index,
                    category: transaction.category,
                    category_th: transaction.category_th,
                    instrument: transaction.instrument,
                    instrument_text: transaction.instrument_text,
                    instrument_two: transaction.instrument_two,
                    instrument_two_text: transaction.instrument_two_text,
                    description: transaction.description,
                    standard: transaction.standard,
                    code: transaction.code,
                    type: transaction.type,
                    measurements: []
                };

                // เพิ่ม measurements ลงใน transactionData
                if (transaction.lab_cal_measurements) {
                    transaction.lab_cal_measurements.forEach(measurement => {
                        const measurementData = {
                            name: measurement.name,
                            ranges: []
                        };

                        // เพิ่ม ranges ลงใน measurementData
                        if (measurement.lab_cal_measurement_ranges) {
                            measurement.lab_cal_measurement_ranges.forEach(range => {
                                measurementData.ranges.push({
                                    description: range.description,
                                    range: range.range,
                                    uncertainty: range.uncertainty
                                });
                            });
                        }

                        transactionData.measurements.push(measurementData);
                    });
                }

                // ถ้า key ใน labTypes ยังเป็น 0 ให้เปลี่ยนเป็น array และเพิ่ม transactionData ลงไป
                if (labTypes[key] === 0) {
                    labTypes[key] = [transactionData];
                } else {
                    labTypes[key].push(transactionData);
                }
            }
        });
    }

    return labTypes;
}

function createLabTestRequestFromServer(serverData, branch_index, type) {
    // กำหนดโครงสร้างพื้นฐานของ labTypes
    let labTypes = {};
   
    // กำหนดค่าเริ่มต้นของ labTypes ตามประเภท (main หรือ branch) เป็น 0
    if (type === 'main') {
        labTypes = {
            pl_2_1_main: 0, // index 0
            pl_2_2_main: 0, // index 1
            pl_2_3_main: 0, // index 2
            pl_2_4_main: 0, // index 3
            pl_2_5_main: 0  // index 4
        };
    } else if (type === 'branch') {
        labTypes = {
            pl_2_1_branch: 0, // index 0
            pl_2_2_branch: 0, // index 1
            pl_2_3_branch: 0, // index 2
            pl_2_4_branch: 0, // index 3
            pl_2_5_branch: 0  // index 4
        };
    }
    
    // ตรวจสอบและเพิ่มข้อมูลจาก serverData.lab_test_transactions
    if (serverData && Array.isArray(serverData.lab_test_transactions)) {
        serverData.lab_test_transactions.forEach(transaction => {
            const key = transaction.key; // ใช้ key จาก transaction เพื่อระบุตำแหน่งใน labTypes

            // ตรวจสอบว่า key มีอยู่ใน labTypes หรือไม่
            if (labTypes[key] !== undefined) {
                // สร้าง transactionData
                const transactionData = {
                    index: transaction.index,
                    category: transaction.category,
                    category_th: transaction.category_th,
                    description: transaction.description,
                    standard: transaction.standard,
                    test_field: transaction.test_field,
                    test_field_eng: transaction.test_field_eng,
                    code: transaction.code,
                    measurements: []
                };

                // เพิ่ม measurements ลงใน transactionData
                if (transaction.lab_test_measurements) {
                    transaction.lab_test_measurements.forEach(measurement => {
                        const measurementData = {
                            name: measurement.name,
                            name_eng: measurement.name,
                            description: transaction.description,
                            detail: measurement.detail,
                            type: measurement.type,
                        };

                        transactionData.measurements.push(measurementData);
                    });
                }

                // ถ้า key ใน labTypes ยังเป็น 0 ให้เปลี่ยนเป็น array และเพิ่ม transactionData ลงไป
                if (labTypes[key] === 0) {
                    labTypes[key] = [transactionData];
                } else {
                    labTypes[key].push(transactionData);
                }
            }
        });
    }

    return labTypes;
}



function createLabTypesFromServer(serverData,branch_index,type) {
    var labTypes = {};
  
    if(type === 'main'){
        labTypes = {
            pl_2_1_main: 0, // index 0
            pl_2_2_main: 0, // index 1
            pl_2_3_main: 0, // index 2
            pl_2_4_main: 0, // index 3
            pl_2_5_main: 0  // index 4
        };
    }else if(type === 'branch'){

        labTypes = {
            pl_2_1_branch: 0, // index 0
            pl_2_2_branch: 0, // index 1
            pl_2_3_branch: 0, // index 2
            pl_2_4_branch: 0, // index 3
            pl_2_5_branch: 0  // index 4
        };
    }

    serverData.forEach(item => {
        const selectedValues = {
            cal_main_branch: item.calibration_branch ? item.calibration_branch.id : '',
            cal_main_branch_text: item.calibration_branch ? `${item.calibration_branch.title}` : '',

            cal_instrumentgroup: item.calibration_branch_instrument_group ? item.calibration_branch_instrument_group.id : '',
            cal_instrumentgroup_text: item.calibration_branch_instrument_group ? `${item.calibration_branch_instrument_group.name}` : '',

            cal_instrument: item.calibration_branch_instrument ? item.calibration_branch_instrument.id : '',
            cal_instrument_text: item.calibration_branch_instrument ? `${item.calibration_branch_instrument.name}` : '',

            cal_parameter_one: item.calibration_branch_param1 ? item.calibration_branch_param1.id : '',
            cal_parameter_one_text: item.calibration_branch_param1 ? `${item.calibration_branch_param1.name}` : '',
            cal_parameter_one_value: item.parameter_one_value || '',

            cal_parameter_two: item.calibration_branch_param2 ? item.calibration_branch_param2.id : '',
            cal_parameter_two_text: item.calibration_branch_param2 ? `${item.calibration_branch_param2.name}` : '',
            cal_parameter_two_value: item.parameter_two_value || '',

            cal_method: item.cal_method || ''
        };

        // ตรวจสอบว่า site_type มีใน labTypes หรือไม่
        if (item.site_type in labTypes) {
            // ถ้า labTypes ยังเป็น 0 (ยังไม่มีค่าใส่)
            if(type === 'main'){
                if (labTypes[item.site_type] === 0) {
                    labTypes[item.site_type] = [selectedValues]; // เริ่มต้นด้วย array ที่มี 1 ค่า
                } else {
                    labTypes[item.site_type].push(selectedValues); // เพิ่มค่าใน array
                }
            }else{


                if (parseInt(item.branch_lab_adress_id) === parseInt(branch_index)) {
                    if (labTypes[item.site_type] === 0) {
                        labTypes[item.site_type] = [selectedValues]; // เริ่มต้นด้วย array ที่มี 1 ค่า
                    } else {
                        labTypes[item.site_type].push(selectedValues); // เพิ่มค่าใน array
                    }
                }
            }

            
        }
    });

    return labTypes;
}


function checkAllCheckboxes() {
    // ฟังก์ชันนับจำนวน checkbox ที่ถูกเลือก
    function countChecked() {
        return $('.check_main:checked').length;
    }

 
//   console.log('countChecked');
//   console.log(countChecked);
    var mainTypesContainer = $('#main-branch-container');
    var checkboxMainBranchContainer = $('#checkbox-main-branch-container');
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    
    // วนลูปตรวจสอบ checkbox ที่ถูกเลือก
    $('.check_main').each(function() {
        var isChecked = $(this).prop('checked'); // ตรวจสอบว่า checkbox ถูกเลือกหรือไม่
        var i = $(this).data('id'); // ดึงค่า data-id จาก checkbox
        var buttonClass = buttonColors[i - 1]; // ใช้ buttonClass ที่เหมาะสม
        var tooltipText = mainFacilityTypes[i - 1].text; 
        // console.log('isChecked');
        if (isChecked) {
            // ถ้า checkbox ถูกเลือก ให้ render ปุ่มตามประเภท
            if (mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).length === 0) {
                mainTypesContainer.append(`<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="${undefined}" title="${tooltipText}">ประเภท ${i}</a>`);
            }

            // อัปเดต lab_main_address.lab_types ตาม checkbox ที่ถูกเลือก
            lab_main_address.lab_types['pl_2_' + i + '_main'] = 1;
        } else {
            // ถ้า checkbox ไม่ถูกเลือก ลบปุ่มออก
            mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();

            // อัปเดต lab_main_address.lab_types สำหรับ checkbox ที่ไม่ได้เลือก
            lab_main_address.lab_types['pl_2_' + i + '_main'] = 0;
        }
    });

    // นับจำนวน checkbox ที่ถูกเลือกทั้งหมด
    let checkedCount = countChecked();
    // console.log(checkedCount);
    // ตรวจสอบว่า checkbox ถูกเลือกกี่ตัวแล้วจัดการการแสดงผลของ checkbox_main
    if (checkedCount !== 0) {
        if (checkboxMainBranchContainer.find('div.checkbox-success').length === 0) {
            checkboxMainBranchContainer.append(`
                <div class="checkbox checkbox-success">
                    <input id="checkbox_main" type="checkbox" data-branch="${undefined}" >
                    <label for="checkbox_main">
                        <span class="font-16"></span>
                    </label>
                </div>
            `);
        }
    } else if (checkedCount === 0) {
        checkboxMainBranchContainer.find('div.checkbox-success').remove();
    }

    // บันทึก lab_main_address กลับไปยัง sessionStorage
    // sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));

    // console.log();
   
    
}


function validateMainScope() {
    var correctMainFormat = false;
    var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || {};

    if (validateLabTypes(lab_main_address.lab_types)) {
        console.log("ข้อมูลสำนักงานใหญ่ถูกต้อง");
        return true
    } else {
        console.log("ข้อมูลสำนักงานใหญ่ไม่ถูกต้อง");
        return false
    }
}

function validateBranchScope() {
    var correctBranchFormat = false;

    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    if (Array.isArray(lab_addresses_array) && lab_addresses_array.length > 0) {
        // ถ้ามีข้อมูล เรียกฟังก์ชัน validateLabAddressesArray
        if (validateLabAddressesArray(lab_addresses_array)) {
            console.log("ข้อมูลสาขาถูกต้อง");
            return true
        } else {
            console.log("ข้อมูลสาขาไม่ถูกต้อง");
            return false
        }
    } 



}


function createLabMainAddressStorage()
{
    
    sessionStorage.removeItem('lab_main_address');
    // ดึงข้อมูล lab_main_address จาก sessionStorage
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address'));
    // console.log(lab_main_address);
    
    // ตรวจสอบ checkbox_main
    var checkbox_main_status = 0;
    var checkbox_main_element = $('#checkbox_main');

    if (checkbox_main_element.length > 0) {
        checkbox_main_status = checkbox_main_element.is(':checked') ? 1 : 0;
    }

    // ถ้าไม่มีข้อมูล lab_main_address ให้สร้างค่า default
    if (!lab_main_address) {
        lab_main_address = {
            lab_type: 'main',
            checkbox_main: checkbox_main_status,
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
        console.log('create main storage');
        // บันทึกข้อมูลใหม่กลับไปที่ session storage
        sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));

    } else {
        // หากมีข้อมูล lab_main_address อยู่แล้ว ให้ใช้ข้อมูลนั้น
        // คุณสามารถทำงานกับ lab_main_address ที่ดึงมานี้ต่อไปได้ เช่นแสดงข้อมูลในฟอร์มหรืออื่น ๆ
        $('#pl_2_1').iCheck(lab_main_address.lab_types.pl_2_1_main != 0 ? 'check' : 'uncheck');
        $('#pl_2_2').iCheck(lab_main_address.lab_types.pl_2_2_main != 0 ? 'check' : 'uncheck');
        $('#pl_2_3').iCheck(lab_main_address.lab_types.pl_2_3_main != 0 ? 'check' : 'uncheck');
        $('#pl_2_4').iCheck(lab_main_address.lab_types.pl_2_4_main != 0 ? 'check' : 'uncheck');
        $('#pl_2_5').iCheck(lab_main_address.lab_types.pl_2_5_main != 0 ? 'check' : 'uncheck');
    } 

        // ถ้าไม่มีข้อมูล lab_branch_address ให้สร้างค่า default
        if (!lab_branch_address) {
            lab_branch_address = {
                lab_type: 'branch',
                checkbox_branch: null,
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
                    pl_2_1_branch: $('#pl_2_1').is(':checked') 
                        ? (Array.isArray(lab_branch_address?.lab_types?.pl_2_1_branch) ? lab_branch_address.lab_types.pl_2_1_branch : 1)
                        : 0,
                    pl_2_2_branch: $('#pl_2_2').is(':checked') 
                        ? (Array.isArray(lab_branch_address?.lab_types?.pl_2_2_branch) ? lab_branch_address.lab_types.pl_2_2_branch : 1)
                        : 0,
                    pl_2_3_branch: $('#pl_2_3').is(':checked') 
                        ? (Array.isArray(lab_branch_address?.lab_types?.pl_2_3_branch) ? lab_branch_address.lab_types.pl_2_3_branch : 1)
                        : 0,
                    pl_2_4_branch: $('#pl_2_4').is(':checked') 
                        ? (Array.isArray(lab_branch_address?.lab_types?.pl_2_4_branch) ? lab_branch_address.lab_types.pl_2_4_branch : 1)
                        : 0,
                    pl_2_5_branch: $('#pl_2_5').is(':checked') 
                        ? (Array.isArray(lab_branch_address?.lab_types?.pl_2_5_branch) ? lab_branch_address.lab_types.pl_2_5_branch : 1)
                        : 0
                },
                address_soi_add: "",
                address_street_add: ""
            };
            console.log('create branch storage');
            // บันทึกข้อมูลใหม่กลับไปที่ session storage
            sessionStorage.setItem('lab_branch_address', JSON.stringify(lab_branch_address));
    
        } else {
            // หากมีข้อมูล lab_branch_address อยู่แล้ว ให้ใช้ข้อมูลนั้น
            // คุณสามารถทำงานกับ lab_branch_address ที่ดึงมานี้ต่อไปได้ เช่นแสดงข้อมูลในฟอร์มหรืออื่น ๆ
            $('#pl_2_1').iCheck(lab_branch_address.lab_types.pl_2_1_branch != 0 ? 'check' : 'uncheck');
            $('#pl_2_2').iCheck(lab_branch_address.lab_types.pl_2_2_branch != 0 ? 'check' : 'uncheck');
            $('#pl_2_3').iCheck(lab_branch_address.lab_types.pl_2_3_branch != 0 ? 'check' : 'uncheck');
            $('#pl_2_4').iCheck(lab_branch_address.lab_types.pl_2_4_branch != 0 ? 'check' : 'uncheck');
            $('#pl_2_5').iCheck(lab_branch_address.lab_types.pl_2_5_branch != 0 ? 'check' : 'uncheck');
        } 
}

function validateLabTypes(labTypes) {
    // Variable to check if any valid array is found
    let validArrayFound = false;

    // Loop through each key in labTypes
    for (let key in labTypes) {
        // Check if the current key's value is an array
        if (Array.isArray(labTypes[key])) {
            // If it's an array, check if it contains at least one item
            if (labTypes[key].length > 0) {
                validArrayFound = true; // Found a valid array
            }
        } else if (labTypes[key] === 1) {
            // If any value is exactly 1 (and not an array), return false
            return false;
        }
    }

    // If no valid array was found, return false
    return validArrayFound;
}

function validateLabAddressesArray(labAddressesArray) {
    // Loop through each object in the labAddressesArray
    for (let i = 0; i < labAddressesArray.length; i++) {
        let labTypes = labAddressesArray[i].lab_types;
        let validArrayFound = false;

        // Loop through each key in lab_types within the current object
        for (let key in labTypes) {
            // Check if the current key's value is an array
            if (Array.isArray(labTypes[key])) {
                // If it's an array, check if it contains at least one item
                if (labTypes[key].length > 0) {
                    validArrayFound = true; // Found a valid array
                }
            } else if (labTypes[key] === 1) {
                // If any value is exactly 1 (and not an array), return false immediately
                return false;
            }
        }

        // If no valid array was found for this labTypes, return false
        if (!validArrayFound) {
            return false;
        }
    }

    // If all objects passed validation, return true
    return true;
}


$("#authorized_address_seach_add_modal").select2({
    dropdownAutoWidth: true,
    width: '100%',
    ajax: {
        url: baseUrl + "funtions/search-addreess",
        type: "get",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                searchTerm: params // search term
            };
        },
        results: function (response) {
            return {
                results: response
            };
        },
        cache: true,
    },
    placeholder: 'คำค้นหา',
    minimumInputLength: 1,
});

$("#authorized_address_seach_add_modal").on('change', function () {
//  url:"/certify/applicant/api/calibrate",
    $.ajax({
        url: baseUrl + "funtions/get-addreess/" + $(this).val()
    }).done(function( jsondata ) {
        if(jsondata != ''){
            console.log(jsondata);
            $('#address_city_add_modal').val(jsondata.pro_id).select2();
            $('#address_district_add_modal').val(jsondata.dis_title);
            $('#sub_district_add_modal').val(jsondata.sub_title);
            $('#address_district_add_modal').attr('data-id', jsondata.dis_id);
            $('#sub_district_add_modal').attr('data-id', jsondata.sub_ids);
            $('#postcode_add_modal').val(jsondata.zip_code);
            $('#lab_province_eng_add_modal').val(jsondata.pro_id).select2();
            $('#lab_amphur_eng_add_modal').val(jsondata.dis_title_en);
            $('#lab_district_eng_add_modal').val(jsondata.sub_title_en);
            $('#lab_postcode_eng_add_modal').val(jsondata.zip_code);
        }
    });
});

// 


// $("#existing_branch").select2({
//     dropdownAutoWidth: true,
//     width: '100%',
//     ajax: {
//         url: baseUrl + "funtions/search-addreess",
//         type: "get",
//         dataType: 'json',
//         delay: 250,
//         data: function (params) {
//             return {
//                 searchTerm: params // search term
//             };
//         },
//         results: function (response) {
//             return {
//                 results: response
//             };
//         },
//         cache: true,
//     },
//     placeholder: 'คำค้นหา',
//     minimumInputLength: 1,
// });

$("#existing_branch").on('change', function () {
    console.log($(this).val())
//  url:"/certify/applicant/api/calibrate",
    $.ajax({
        url: baseUrl + "funtions/get-branch-addreess/" + $(this).val()
    }).done(function( jsondata ) {
        if(jsondata != ''){
            console.log(jsondata);
            $('#address_city_add_modal').val(jsondata.pro_id).select2();
            $('#address_district_add_modal').val(jsondata.dis_title);
            $('#sub_district_add_modal').val(jsondata.sub_title);
            $('#address_district_add_modal').attr('data-id', jsondata.dis_id);
            $('#sub_district_add_modal').attr('data-id', jsondata.sub_ids);
            $('#postcode_add_modal').val(jsondata.zip_code);
            $('#lab_province_eng_add_modal').val(jsondata.pro_id).select2();
            $('#lab_amphur_eng_add_modal').val(jsondata.dis_title_en);
            $('#lab_district_eng_add_modal').val(jsondata.sub_title_en);
            $('#lab_postcode_eng_add_modal').val(jsondata.zip_code);

            $('#address_number_add_modal').val(jsondata.address_no);
            $('#village_no_add_modal').val(jsondata.moo);
            $('#lab_address_no_eng_add_modal').val(jsondata.address_no);
            $('#lab_moo_eng_add_modal').val(jsondata.moo);
            
            

        }
    });
});


$('#modal-add-parameter-one').on('shown.bs.modal', function () {
    // Destroy existing Summernote instance
    $('#parameter_one_textarea').summernote('destroy');
    
    // Reinitialize with desired settings
    $('#parameter_one_textarea').summernote({
        height: 150,
        toolbar: [
            ['para', ['ul', 'ol', 'paragraph']], // เพิ่มเครื่องมือจัดข้อความ
        ],
    });
});


// $('#modal-add-parameter-one').on('shown.bs.modal', function () {
//     // Destroy existing Summernote instance
//     $('#parameter_one_textarea').summernote('destroy');
    
//     // Reinitialize with desired settings
//     $('#parameter_one_textarea').summernote({
//         height: 150,
//         toolbar: [
//             ['para', ['ul', 'ol', 'paragraph']], // เพิ่มเครื่องมือจัดข้อความ
//             ['insert', ['ohmSymbol']] // เพิ่มปุ่มสำหรับเครื่องหมายโอห์ม
//         ],
//         buttons: {
//             ohmSymbol: function() {
//                 var ui = $.summernote.ui;
//                 return ui.button({
//                     contents: 'Ω',
//                     tooltip: 'Insert Ohm symbol',
//                     click: function() {
//                         $('#parameter_one_textarea').summernote('insertText', 'Ω');
//                     }
//                 }).render();
//             }
//         }
//     });
// });

$('.symbol-btn-add-cal-parameter').on('click', function() {
    var symbol = $(this).data('symbol');
    
    // เพิ่มสัญลักษณ์ลงใน Summernote ของ #parameter_one_textarea
    // $('#cal_param_range_textarea').summernote('insertText', symbol);
    // $('#cal_param_range_textarea').val(symbol);

    $('#cal_param_range_textarea').val(function (index, currentValue) {
        return currentValue + symbol;
    });
    

    // ปิด modal-add-parameter-one-symbol หลังจากเพิ่มสัญลักษณ์
    $('#modal-add-parameter-symbol').modal('hide');
});

$('.symbol-btn-add-cal-cmc').on('click', function() {
    var symbol = $(this).data('symbol');
    
    // เพิ่มสัญลักษณ์ลงใน Summernote ของ #parameter_one_textarea
    // $('#cal_param_range_textarea').summernote('insertText', symbol);
    // $('#cal_cmc_uncertainty_textarea').val(symbol);
    $('#cal_cmc_uncertainty_textarea').val(function (index, currentValue) {
        return currentValue + symbol;
    });
    

    // ปิด modal-add-parameter-one-symbol หลังจากเพิ่มสัญลักษณ์
    $('#modal-add-cmc-symbol').modal('hide');
});


$('.symbol-btn-add-parameter-one').on('click', function() {
    var symbol = $(this).data('symbol');
    
    // เพิ่มสัญลักษณ์ลงใน Summernote ของ #parameter_one_textarea
    $('#parameter_one_textarea').summernote('insertText', symbol);

    // ปิด modal-add-parameter-one-symbol หลังจากเพิ่มสัญลักษณ์
    $('#modal-add-parameter-one-symbol').modal('hide');
});

$('.symbol-btn-add-parameter-two').on('click', function() {
    var symbol = $(this).data('symbol');
    
    // เพิ่มสัญลักษณ์ลงใน Summernote ของ #parameter_two_textarea
    $('#parameter_two_textarea').summernote('insertText', symbol);

    // ปิด modal-add-parameter-two-symbol หลังจากเพิ่มสัญลักษณ์
    $('#modal-add-parameter-two-symbol').modal('hide');
});

$('.symbol-btn-add-cal-method').on('click', function() {
    var symbol = $(this).data('symbol');
    
    // เพิ่มสัญลักษณ์ลงใน Summernote ของ #cal_method_textarea
    $('#cal_method_textarea').summernote('insertText', symbol);

    // ปิด modal-add-cal-method-symbol หลังจากเพิ่มสัญลักษณ์
    $('#modal-add-cal-method-symbol').modal('hide');
});

$('#modal-add-parameter-two').on('shown.bs.modal', function () {
    // Destroy existing Summernote instance
    $('#parameter_two_textarea').summernote('destroy');
    
    // Reinitialize with desired settings
    $('#parameter_two_textarea').summernote({
        height: 150,
        toolbar: [
            ['para', ['ul', 'ol', 'paragraph']], // เพิ่มเครื่องมือจัดข้อความ
        ],
    });
});

$('#modal-add-cal-method').on('shown.bs.modal', function () {
    // Destroy existing Summernote instance
    $('#cal_method_textarea').summernote('destroy');
    
    // Reinitialize with desired settings
    $('#cal_method_textarea').summernote({
        height: 200,
        toolbar: [
            ['para', ['ul', 'ol', 'paragraph']], // เพิ่มเครื่องมือจัดข้อความ
        ],
    });
});

// $('#show_add_address').click(function(){
$(document).on('click', '#show_add_address', function(e) {
    // รีเซ็ตค่าของฟิลด์ต่างๆ
    e.preventDefault();
    
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

        const _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/certify/applicant/api/get-existing-branch",
            method:"POST",
            data:{
                _token:_token
            },
            success:function (result){
                $('#modal-add-address').modal('show');
                $('#existing_branch').empty();
                $('#existing_branch').append(`<option value="null">-เลือกสาขา-</option>`);
                result.forEach(function(branch) {
                    $('#existing_branch').append(`<option value="${branch.id}">${branch.name}</option>`);
                });
            }
        });
    
        // แสดง modal
    
    });

   // เมื่อค่าใน #address_number_add_modal เปลี่ยน
$('#address_number_add_modal').on('change', function() {
    // ดึงค่าจาก #address_number_add_modal
    var addressNumber = $(this).val();
    
    // ตั้งค่าของ #lab_address_no_eng_add_modal ให้เท่ากับค่าที่ดึงมา
    $('#lab_address_no_eng_add_modal').val(addressNumber);
});

$('#address_number').on('change', function() {
    // ดึงค่าจาก #address_number_add_modal
    var addressNumber = $(this).val();
    
    // ตั้งค่าของ #lab_address_no_eng_add_modal ให้เท่ากับค่าที่ดึงมา
    $('#lab_address_no_eng').val(addressNumber);
});

// $('#create_address').click(function() {
$(document).on('click', '#create_address', function(e) {
    e.preventDefault();
    // ดึงค่าจากฟิลด์ต่างๆ

    if ($('#create_address').text().trim() === "แก้ไข") {
        return;
    }

    console.log($('#create_address').text().trim());

    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    console.log('จังหวัด',$('#address_city_add_modal').val())
    console.log('อำเภอ',$('#address_district_add_modal').data('id'))
    console.log('ตำบล',$('#sub_district_add_modal').data('id'))

    // ดึงค่าจากฟอร์มและแปลงเป็นตัวเลข
    const cityValue = parseInt($('#address_city_add_modal').val(), 10);
    const districtId = parseInt($('#address_district_add_modal').data('id'), 10);
    const subDistrictId = parseInt($('#sub_district_add_modal').data('id'), 10);

    // เปรียบเทียบกับข้อมูลใน lab_addresses_array
    const isExist = lab_addresses_array.some(address => {
        return parseInt(address.address_city_add_modal, 10) === cityValue &&
            parseInt(address.address_district_add_modal_id, 10) === districtId &&
            parseInt(address.sub_district_add_modal_id, 10) === subDistrictId;
    });

    if (isExist) {
        alert("มีสาขานี้แล้วในระบบ โปรดลบแล้วเพิ่มใหม่อีกครั้ง");
        return;
    } 

    var lab_address = {
        lab_type: 'branch',
        address_number_add_modal: $('#address_number_add_modal').val(),
        village_no_add_modal: $('#village_no_add_modal').val(),
        address_soi_add_modal: $('#address_soi_add_modal').val(),
        address_street_add_modal: $('#address_street_add_modal').val(),
        address_city_add_modal: $('#address_city_add_modal').val(),
        address_city_text_add_modal: $('#address_city_add_modal option:selected').text(), 
        address_district_add_modal: $('#address_district_add_modal').val(),
        address_district_add_modal_id: $('#address_district_add_modal').data('id'),

        sub_district_add_modal: $('#sub_district_add_modal').val(),
        sub_district_add_modal_id: $('#sub_district_add_modal').data('id'),

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
        
    };

    // ตรวจสอบว่าฟิลด์ที่ต้องไม่ว่างมีค่าหรือไม่
    if (!lab_address.address_number_add_modal || 
        
        !lab_address.address_city_add_modal || 
        !lab_address.address_district_add_modal || 
        !lab_address.sub_district_add_modal || 
        !lab_address.postcode_add_modal || 
        !lab_address.lab_address_no_eng_add_modal || 
        !lab_address.lab_province_eng_add_modal || 
        !lab_address.lab_amphur_eng_add_modal || 
        !lab_address.lab_district_eng_add_modal ) {

        alert('กรุณากรอกข้อมูลที่ระบุ * ให้ครบ');
        return; // หยุดการทำงานถ้ามีฟิลด์ที่ยังไม่ได้กรอก
    }


    // ตรวจสอบว่ามีการเลือก type อย่างน้อยหนึ่งรายการ
    var isAnyTypeSelected = Object.values(lab_address.lab_types).some(function(value) {
        return value === 1;
    });

    if (!isAnyTypeSelected) {
        alert('กรุณาเลือกประเภทสถานปฏิบัติการของห้องปฏิบัติการอย่างน้อยหนึ่งรายการ');
        return; // หยุดการทำงานถ้าไม่มีการเลือก type
    }

    // ดึง array จาก session storage ถ้าไม่มีให้สร้างใหม่
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    // เพิ่ม lab_address ใหม่เข้าไปใน array
    lab_addresses_array.push(lab_address);

    // บันทึก array กลับไปที่ session storage
    sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));

    // แสดง array เพื่อให้เห็นข้อมูลที่ถูกเพิ่มเข้าไป
    // console.log(lab_addresses_array);
    renderTable(lab_addresses_array);
    
    $('#modal-add-address').modal('hide'); // Toggle modal
});

function renderTable(lab_addresses_array) {
    // ลบเนื้อหาเก่าใน tbody ก่อน
    $('#lab_address_body').empty();
    $('#lab_address_with_scope_body').find('tr:not(:first)').remove();


    lab_addresses_array.forEach(function(address, index) {
        // var row1 = `
        //     <tr>
        //         <td class="text-center" style="vertical-align:top">${index + 1}</td>
        //         <td style="vertical-align:top">
        //             เลขที่ ${address.address_number_add_modal}, หมู่ ${address.village_no_add_modal}, 
        //             แขวง/อำเภอ${address.sub_district_add_modal}, เขต/อำเภอ${address.address_district_add_modal}, 
        //             จังหวัด${address.address_city_text_add_modal}
        //         </td>
        //         <td class="text-center">
        //             <button type="button" class="btn btn-warning btn-xs addressEdit" data-index="${index}">
        //                 <i class="fa fa-edit"></i>
        //             </button>
        //             <button type="button" class="btn btn-danger btn-xs addressDelete" data-index="${index}">
        //                 <i class="fa fa-remove"></i>
        //             </button>
        //         </td>
        //     </tr>
        // `;
        var row1 = `
            <tr>
                <td class="text-center" style="vertical-align:top">${index + 1}</td>
                <td style="vertical-align:top">
                    เลขที่ ${address.address_number_add_modal}, หมู่ ${address.village_no_add_modal}, 
                    แขวง/อำเภอ${address.sub_district_add_modal}, เขต/อำเภอ${address.address_district_add_modal}, 
                    จังหวัด${address.address_city_text_add_modal}
                </td>
                <td class="text-center">
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
            var tooltipText = branchFacilityTypes[0].text; 
            typesHtml += `<a class="btn btn-primary btn-xs add-lab-scope" data-type="1" data-branch="${index}" title="${tooltipText}">ประเภท 1</a> `;
        }
        if (address.lab_types.pl_2_2_branch) {
            var tooltipText = branchFacilityTypes[1].text; 
            typesHtml += `<a class="btn btn-success btn-xs add-lab-scope" data-type="2" data-branch="${index}" title="${tooltipText}">ประเภท 2</a> `;
        }
        if (address.lab_types.pl_2_3_branch) {
            var tooltipText = branchFacilityTypes[2].text; 
            typesHtml += `<a class="btn btn-info btn-xs add-lab-scope" data-type="3" data-branch="${index}" title="${tooltipText}">ประเภท 3</a> `;
        }
        if (address.lab_types.pl_2_4_branch) {
            var tooltipText = branchFacilityTypes[3].text; 
            typesHtml += `<a class="btn btn-warning btn-xs add-lab-scope" data-type="4" data-branch="${index}" title="${tooltipText}">ประเภท 4</a> `;
        }
        if (address.lab_types.pl_2_5_branch) {
            var tooltipText = branchFacilityTypes[4].text; 
            typesHtml += `<a class="btn btn-danger btn-xs add-lab-scope" data-type="5" data-branch="${index}" title="${tooltipText}">ประเภท 5</a> `;
        }

        
        commonScopeHtml = `<a class="btn btn-primary btn-xs add-lab-scope data-type="" data-branch="${index}">เพิ่มขอบข่ายร่วม</a>`;

        // Render ตารางที่สอง
        // var row2 = `
        //     <tr>
        //         <td class="text-center" style="vertical-align:top">${index + 2}</td>
        //         <td style="vertical-align:top">
        //             เลขที่ ${address.address_number_add_modal}, หมู่ ${address.village_no_add_modal}, 
        //             แขวง/อำเภอ${address.sub_district_add_modal}, เขต/อำเภอ${address.address_district_add_modal}, 
        //             จังหวัด${address.address_city_text_add_modal}
        //         </td>
        //         <td class="text-center">
        //             <div class="checkbox checkbox-success">
        //                 <input id="checkbox_${index + 1}" type="checkbox" data-branch="${index}" checked class="lab-scope-checkbox">
        //                 <label for="checkbox_${index + 1}">
        //                     <span class="font-16"></span>
        //                 </label>
        //             </div>
        //         </td>
        //         <td class="text-center types-container">
        //             ${commonScopeHtml}
        //         </td>
        //     </tr>
        // `;
        var row2 = `
            <tr>
                <td class="text-center" style="vertical-align:top">${index + 2}</td>
                <td style="vertical-align:top">
                    เลขที่ ${address.address_number_add_modal}, หมู่ ${address.village_no_add_modal}, 
                    แขวง/อำเภอ${address.sub_district_add_modal}, เขต/อำเภอ${address.address_district_add_modal}, 
                    จังหวัด${address.address_city_text_add_modal}
                </td>

                <td class="text-center types-container">
                    ${typesHtml}
                </td>
            </tr>
        `;
        $('#lab_address_with_scope_body').append(row2);
    });

}

// เพิ่ม event listener สำหรับปุ่มลบ
$(document).on('click', '.addressDelete', function(e) { 
    e.preventDefault();

    // ดึงข้อมูล lab_addresses_array จาก sessionStorage
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    // ดึง index จาก data-index ของปุ่ม
    var index = $(this).data('index');

    // คำเตือนก่อนลบ
    const confirmation = confirm("ต้องการลบสาขาหรือไม่? ขอบข่ายทั้งหมดของสาขานี้จะถูกลบ.");

    if (confirmation) {
        // ลบที่ตำแหน่ง index นั้น
        lab_addresses_array.splice(index, 1);

        // บันทึกการเปลี่ยนแปลงใน sessionStorage
        sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));

        // ตรวจสอบ labRequestType และเรียกใช้ฟังก์ชั่นที่เกี่ยวข้อง
        if (labRequestType == "test") {
            renderTestScopeWithParameterTable();
        } else if (labRequestType == "cal") {
            renderCalScopeWithParameterTable();
        }  

        // แสดงข้อมูลใหม่ในตารางทั้งสอง
        renderTable(lab_addresses_array); 
    } else {
        // ถ้าผู้ใช้กดยกเลิก ไม่ทำการลบ
        console.log("การลบถูกยกเลิก");
    }
});


// เพิ่ม event listener สำหรับปุ่มแก้ไข
$(document).on('click', '.addressEdit', function(e) { 
    e.preventDefault();
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    var index = $(this).data('index');
    var address = lab_addresses_array[index];

    console.log(address);

    // โหลดข้อมูลกลับเข้าสู่ฟอร์ม
    $('#address_number_add_modal').val(address.address_number_add_modal);
    $('#village_no_add_modal').val(address.village_no_add_modal);
    $('#address_soi_add_modal').val(address.address_soi_add_modal);
    $('#address_street_add_modal').val(address.address_street_add_modal);
    
    // กำหนดค่า select box
    $('#address_city_add_modal').val(address.address_city_add_modal).change();
    $('#lab_province_eng_add_modal').val(address.lab_province_eng_add_modal).change();

    $('#address_district_add_modal').val(address.address_district_add_modal);
    $('#sub_district_add_modal').val(address.sub_district_add_modal);

    $('#address_district_add_modal').attr('data-id', address.address_district_add_modal_id);
    $('#sub_district_add_modal').attr('data-id', address.sub_district_add_modal_id);

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

    $(document).on('click', '#create_address', function(e) {  
        alert('what')  ;
        e.preventDefault();

        lab_addresses_array[index] = {
            lab_type: 'branch',
            address_number_add_modal: $('#address_number_add_modal').val(),
            village_no_add_modal: $('#village_no_add_modal').val(),
            address_city_add_modal: $('#address_city_add_modal').val(),
            address_city_text_add_modal: $('#address_city_add_modal option:selected').text(),
            address_district_add_modal: $('#address_district_add_modal').val(),
            sub_district_add_modal: $('#sub_district_add_modal').val(),
            postcode_add_modal: $('#postcode_add_modal').val(),

            address_district_add_modal_id: $('#address_district_add_modal').data('id'),
    
            sub_district_add_modal_id: $('#sub_district_add_modal').data('id'),

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
$(document).on('click', '.add-lab-scope', function(e) {
    e.preventDefault();
    globalTypeNumber = $(this).data('type');
    globalBranchNumber = $(this).data('branch');

    if (globalTypeNumber === "undefined" || globalTypeNumber === "") {
        globalTypeNumber = undefined;
    }
    
    if (globalBranchNumber === "undefined" || globalBranchNumber === "") {
        globalBranchNumber = undefined;
    }

    // var isChecked = $('#checkbox_' + (globalBranchNumber+1)).is(':checked');

    // console.log(isChecked);

    console.log(globalTypeNumber);
    console.log(globalBranchNumber);
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    if(globalTypeNumber === undefined){
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
                // หา referenceItem จากคีย์แรกที่เป็น array
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key])) {
                        referenceItem = lab_types[key]; // ใช้รายการแรกเป็น reference
                        break;
                    }
                }

                // ถ้ามี referenceItem แล้วเปรียบเทียบกับรายการอื่นๆ
                if (referenceItem) {
                    for (var key in lab_types) {
                        if (Array.isArray(lab_types[key])) {
                            for (var index = 0; index < lab_types[key].length; index++) {
                                var item = lab_types[key][index];
                                var refItem = referenceItem[index];

                                // ตรวจสอบว่าทุกคีย์ใน item และ refItem เหมือนกันหรือไม่
                                for (var prop in refItem) {
                                    if (item[prop] !== refItem[prop]) {
                                        // alert(`พบค่าที่ไม่เหมือนกันใน ${key} ที่ index ${index}, property: ${prop}`);
                                        diffScopeFound = true;
                                        break; // หยุดการทำงานของ for loop ภายในเมื่อเจอค่าที่ไม่เหมือนกัน
                                    }
                                }

                                if (diffScopeFound) {
                                    break; // หยุดการทำงานของ for loop หลักเมื่อเจอค่าที่ไม่เหมือนกัน
                                }
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

    if (diffScopeFound === true && globalTypeNumber === undefined) {
        // alert('ตรวจพบ Scope ของแต่ละประเภทแตกต่างกัน โปรดเลือกประเภทหลัก ประเภทอื่น ๆ ถูกปรับ scope ร่วมกับประเภทที่เลือก');

        // ตรวจสอบว่ามีข้อมูลใน globalBranchNumber หรือไม่
        if (lab_addresses_array[globalBranchNumber]) {
            var lab_types = lab_addresses_array[globalBranchNumber].lab_types;

            // เคลียร์ตัวเลือกทั้งหมดใน select element ก่อนด้วย jQuery
            var $selectMainType = $('#select_ref_branch');
            $selectMainType.empty(); // เคลียร์ตัวเลือกทั้งหมด

            for (var key in lab_types) {
                if (Array.isArray(lab_types[key])) {
                    // ตรวจสอบว่าคีย์ตรงกับ id ใน branchFacilityTypes หรือไม่
                    var matchedFacility = branchFacilityTypes.find(function(facility) {
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

        $('#modal-select-ref-branch').modal('show');
    }
    else
    {
        showAddCalScopeModal();
    }

});


$(document).on('click', '#button_select_ref_branch', function(e) {
    e.preventDefault();
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    var selectedValue = $('#select_ref_branch').val(); // ดึงค่า value จาก select_ref_branch
    
    // ตรวจสอบว่า selectedValue มีค่าหรือไม่
    if (!selectedValue) {
        alert('กรุณาเลือกประเภทหลัก!');
        return; // หยุดการทำงานถ้าไม่มีค่า
    }
    
    var selectedText = $('#select_ref_branch option:selected').text(); // ดึงข้อความที่แสดงในตัวเลือกที่ถูกเลือก
    var scopes = lab_addresses_array[globalBranchNumber].lab_types[selectedValue];

    var lab_types = lab_addresses_array[globalBranchNumber].lab_types;

    for (var key in lab_types) {
        if (Array.isArray(lab_types[key]) || lab_types[key] == 1) {
            lab_types[key] = [...scopes]; // อัพเดทคีย์ให้เหมือนกับ scopes
        }
    }

    sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
    console.log('Updated lab_types:', lab_types); // ดูผลลัพธ์ของการอัพเดท
    $('#modal-select-ref-branch').modal('hide');
    showAddCalScopeModal();
});

$(document).on('click', '#button_select_ref_main', function(e) {
    e.preventDefault();
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    var selectedValue = $('#select_ref_main').val(); // ดึงค่า value จาก select_ref_main
    
    // ตรวจสอบว่า selectedValue มีค่าหรือไม่
    if (!selectedValue) {
        alert('กรุณาเลือกประเภทหลัก!');
        return; // หยุดการทำงานถ้าไม่มีค่า
    }
    
    var selectedText = $('#select_ref_main option:selected').text(); // ดึงข้อความที่แสดงในตัวเลือกที่ถูกเลือก
    var scopes = lab_main_address.lab_types[selectedValue];

    var lab_types = lab_main_address.lab_types;

    for (var key in lab_types) {
        if (Array.isArray(lab_types[key]) || lab_types[key] == 1) {
            lab_types[key] = [...scopes]; // อัพเดทคีย์ให้เหมือนกับ scopes
        }
    }

    // console.log('im here');
    sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
    console.log('Updated lab_types:', lab_types); // ดูผลลัพธ์ของการอัพเดท
    // lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    // console.log('Updated lab_main_address:', lab_main_address); // ดูผลลัพธ์ของการอัพเดท
    $('#modal-select-ref-main').modal('hide');
    showAddCalScopeModal();
});


function clearAndRewriteSelectWrapper() {
    // ลบเนื้อหาทั้งหมดใน select_wrapper
    $('#select_wrapper').html('');

    // เขียนโครงสร้างใหม่
    var newHtml = `
        <div class="col-md-4 form-group">
            <label for="">สาขาการสอบเทียบ</label>
            <select class="form-control" name="" id="cal_main_branch">
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="">เครื่องมือ1</label>
            <select class="form-control" name="" id="cal_instrumentgroup">
            </select>
        </div>
        <div class="col-md-4 form-group" id="cal_instrument_wrapper">
            <label for="">เครื่องมือ2</label>
            <select class="form-control" name="" id="cal_instrument">
            </select>
        </div>
        <div class="col-md-4 form-group" id="cal_parameters_wrapper">
            <label for="">เลือกพารามิเตอร์</label>
            <select class="form-control" name="" id="cal_parameters">
            </select>
        </div>
        <div class="col-md-4 form-group" id="cal_parameter_one_wrapper">
            <label for="">พารามิเตอร์1</label>
            <select class="form-control" name="" id="cal_parameter_one">
            </select>
        </div>
        <div class="col-md-4 form-group" id="cal_parameter_two_wrapper">
            <label for="">พารามิเตอร์2</label>
            <select class="form-control" name="" id="cal_parameter_two">
            </select>
        </div>
    `;

    

    // ใส่โครงสร้างใหม่กลับเข้าไปใน select_wrapper
    $('#select_wrapper').html(newHtml);

    // Initialize Select2 สำหรับ select ที่ต้องการ
    $('#cal_main_branch, #cal_instrumentgroup, #cal_instrument, #cal_parameters, #cal_parameter_one, #cal_parameter_two').select2();
}

function showAddCalScopeModal()
{

    clearAndRewriteSelectWrapper();

    $('#lab_cal_scope_body').html('');
        var selectedValue = $('input[name="lab_ability"]:checked').val();
        const _token = $('input[name="_token"]').val();

        if (selectedValue === 'test') {
            $('#test_parameter_wrapper').hide();
            $('#test_infomation_scope').hide();
            $.ajax({
                    // url:"{{route('api.test')}}",
                    url:"/certify/applicant/api/test",
                    method:"POST",
                    data:{
                        _token:_token
                    },
                    success:function (result){
                        // ล้างค่าเดิมใน select element ก่อนเพิ่มค่าใหม่
                        $('#test_main_branch').empty();
                        $('#test_main_branch').select2('destroy').empty();
                        $('#test_main_branch').append('<option value="not_select" disabled selected>- สาขาทดสอบ -</option>');

                        $.each(result, function (index, value) {
                            $('#test_main_branch').append('<option value="' + value.id + '" data-id="' + value.title_en + '">' + value.title + '</option>');
                        });
                        $('#test_main_branch').select2();
                    }
                });
            $('#modal-add-test-scope').modal('show');   
        } else if (selectedValue === 'calibrate') {
            $('#cal_instrument_wrapper').hide();
            $('#cal_parameter_one_wrapper').hide();
            $('#cal_parameters_wrapper').hide();
            $('#cal_parameter_two_wrapper').hide();
            $('#cal_infomation_scope').hide();
            $.ajax({
                    // url:"{{route('api.calibrate')}}",
                    url:"/certify/applicant/api/calibrate",
                    method:"POST",
                    data:{
                        _token:_token
                    },
                    success:function (result){
                        // ล้างค่าเดิมใน select element ก่อนเพิ่มค่าใหม่
                        $('#cal_main_branch').empty();
                        $('#cal_main_branch').select2('destroy').empty();
                        $('#cal_main_branch').append('<option value="not_select" disabled selected>- สาขาสอบเทียบ -</option>');

                        $.each(result,function (index,value) {
                            $('#cal_main_branch').append('<option value='+value.id+' data-id='+value.title_en+'>'+value.title+'</option>')
                        });
                        $('#cal_main_branch').select2();
                    }
                });

            // renderCalScopeTable(globalBranchNumber, globalTypeNumber);
            $('#modal-add-cal-scope').modal('show');
        }
}


$(document).on('change', '#cal_main_branch', function() {
    var bcertify_calibration_branche_id = $(this).val();
    const _token = $('input[name="_token"]').val();
    $('#cal_instrument_wrapper').hide();
    $('#cal_parameter_one_wrapper').hide();
    $('#cal_parameters_wrapper').hide();
    $('#cal_parameter_two_wrapper').hide();
    $('#cal_infomation_scope').hide();
    

    $.ajax({
        // url: "{{route('api.instrumentgroup')}}",
        url: "/certify/applicant/api/instrumentgroup",
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
            $('#cal_instrumentgroup').append('<option value="not_select" disabled selected>- เลือกเครื่องมือ1 -</option>');
            
            $.each(result, function(index, value) {
                $('#cal_instrumentgroup').append('<option value=' + value.id + '>' + value.name + '</option>');
            });

            // Reinitialize select2
            $('#cal_instrumentgroup').select2();
        }
    });
});


$(document).on('change', '#test_main_branch', function() {
    var bcertify_test_branche_id = $(this).val();
    const _token = $('input[name="_token"]').val();
    $('#test_parameter_wrapper').hide();
    $('#test_infomation_scope').hide();
    

    $.ajax({
        // url: "{{route('api.instrumentgroup')}}",
        url: "/certify/applicant/api/test_category",
        method: "POST",
        data: {
            bcertify_test_branche_id: bcertify_test_branche_id,
            _token: _token
        },
        success: function(result) {
            // Clear selected value and options
            $('#test_category').select2('destroy').empty(); // Destroy select2 instance and clear options

            // Reinitialize select2 with an empty option
            $('#test_category').append('<option value="not_select" disabled selected>- เลือกหมวดหมู่ -</option>');
            
            $.each(result, function(index, value) {
                $('#test_category').append('<option value='+value.id+' data-id='+value.name_eng+'>' + value.name + '</option>');
            });

            // Reinitialize select2
            $('#test_category').select2();
        }
    });
});

$(document).on('change', '#test_category', function() {
    var test_branch_category_id = $(this).val();
    const _token = $('input[name="_token"]').val();
    $('#test_parameter_wrapper').hide();
    $('#test_infomation_scope').hide();

    $.ajax({
        // url: "{{route('api.instrumentgroup')}}",
        url: "/certify/applicant/api/test_parameter",
        method: "POST",
        data: {
            test_branch_category_id: test_branch_category_id,
            _token: _token
        },
        success: function(result) {
            $('#test_parameter_wrapper').show();
            // Clear selected value and options
            $('#test_parameter').val(null).trigger('change'); // Clear selected value
            $('#test_parameter').select2('destroy').empty(); // Destroy select2 instance and clear options

            // Reinitialize select2 with an empty option
            $('#test_parameter').append('<option value="not_select" disabled selected>- เลือกพารามิเตอร์ -</option>');
            
            $.each(result, function(index, value) {
                $('#test_parameter').append('<option value='+value.id+' data-id='+value.name_eng+'>' + value.name + '</option>');
            });

            // Reinitialize select2
            $('#test_parameter').select2();

          
            // เพิ่มการเปลี่ยนแปลงใน #cal_parameters
            $('#test_parameter').on('change', function () {
                $('#test_infomation_scope').show();
                // test_measurements = [];
                // let parameterName = $(this).find(':selected').text();
                // let parameterType = $(this).val(); 
                

                // let existingMeasurement = test_measurements.find(measurement => measurement.name === parameterName);
            
                // if (!existingMeasurement) {
                //     test_measurements.push({
                //         name: parameterName,
                //         type: parameterType,
                //         ranges: [] 
                //     });
                // } else {
                //     existingMeasurement.type = parameterType;
                // }
                // console.log(test_measurements)
            });

            $('#button_add_test_param').on('click', function () {
                $('#modal-add-test-param').modal('show');
            });

        }
    });

    // เพิ่มข้อมูลลงใน ranges
    $('#btn_add_test_param').on('click', function () {
        // ดึงค่าจากฟอร์ม
        let description = document.getElementById('description').value;
        let detail = document.getElementById('test_param_detail_textarea').value;



        // // เพิ่มข้อมูลลงใน ranges ของ measurement แรก
       
        test_measurements.push({
            description: description,
            range: detail, // หากไม่มีบรรทัด ใช้ค่าว่าง
        });
      

        console.log(test_measurements);

        // // แสดงข้อมูลในตาราง
        // renderParamCMCTable();

        // // ล้างฟิลด์ในฟอร์ม
        // $('#description').val('');
        // $('#cal_param_range_textarea').val('');
        // $('#cal_cmc_uncertainty_textarea').val('');
        // $('#cal_param_file').val('');
        // $('#cal_cmc_file').val('');
        // $('#modal-add-cal-param-cmc').modal('hide');
    });

});


$('#button_add_test_scope').on('click', function () {
    test_measurements = [];
    lab_test_scope_data_transaction = [];
    // ดึงค่าจากฟอร์ม
    let category = $('#test_main_branch').val(); 
    let category_th = $('#test_main_branch option:selected').text(); 
    let category_eng = $('#test_main_branch option:selected').data('id');
    let category_id = $('#test_main_branch option:selected').val();
    let test_field = $('#test_category').val(); 
    let test_field_th = $('#test_category option:selected').text();
    let test_field_eng = $('#test_category option:selected').data('id');
    let test_parameter = $('#test_parameter').val(); 
    let test_parameter_th = $('#test_parameter option:selected').text();
    let test_parameter_en = $('#test_parameter option:selected').data('id');

    let standard = $('#test_standard_txtarea').val(); 
    let condition_description = $('#test_condition_description').val(); 
    let detail = $('#test_param_detail_textarea').val(); 
    let description = $('#test_parameter_desc').val(); 

    console.log(category_eng);

    if (!category || category === "") {
        // ถ้า category ไม่มีค่า
        alert('กรุณาเลือกสาขาทดสอบ');
        return;  // หยุดการทำงานที่เหลือ
    }

    if (!test_field || test_field === "") {
        // ถ้า category ไม่มีค่า
        alert('กรุณาเลือกหมวดหมู่การทดสอบ');
        return;  // หยุดการทำงานที่เหลือ
    }

    if (!test_parameter || test_parameter === "") {
        // ถ้า category ไม่มีค่า
        alert('กรุณาเลือกพารามิเตอร์');
        return;  // หยุดการทำงานที่เหลือ
    }



    
    let existingMeasurement = test_measurements.find(measurement => measurement.name === test_parameter_th);
        
    if (!existingMeasurement) {
        test_measurements.push({
            name: test_parameter_th,
            name_eng: test_parameter_en,
            type: "parameter",
            description: condition_description,
            detail: detail,
        });
    }

   let test_measurementsCopy = JSON.parse(JSON.stringify(test_measurements));



    if (globalTypeNumber !== undefined && globalBranchNumber !== undefined) {
        console.log('สาขาแยกขอบข่าย aaa');

        let propertyName = `pl_2_${globalTypeNumber}_branch`;

        console.log(lab_addresses_array[globalBranchNumber].lab_types[propertyName])
        
        // ตรวจสอบว่า `propertyName` เป็น array หรือไม่
        if (!Array.isArray(lab_addresses_array[globalBranchNumber].lab_types[propertyName])) {
            lab_addresses_array[globalBranchNumber].lab_types[propertyName] = []; // ถ้าไม่ใช่ ให้ตั้งเป็น array ว่าง
        }

        // คำนวณ index จากลำดับของ array เดิม
        let index = lab_addresses_array[globalBranchNumber].lab_types[propertyName].length;

        let newEntry = {
            index: index,
            category: category_id,
            category_th: category_th,
            test_field: test_field_th,
            test_field_eng: test_field_eng,
            description: description,
            standard: standard,
            code: "2",
            measurements: test_measurementsCopy,
        };
    
        // เพิ่มข้อมูลใหม่ใน lab_cal_scope_data_transaction
        // lab_test_scope_data_transaction.push(newEntry);

        lab_addresses_array[globalBranchNumber].lab_types[propertyName].push(newEntry)

        sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
        lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

        console.log('lab_addresses_array',lab_addresses_array)



    } else if (globalTypeNumber === undefined && globalBranchNumber !== undefined ) {
        console.log('สาขาขอบข่ายร่วมกกก');
    }else if(globalTypeNumber === undefined && globalBranchNumber === undefined ){
        console.log('สำนักงานใหญ่ขอบข่ายร่วม')
    }else if(globalTypeNumber !== undefined && globalBranchNumber === undefined ){
        console.log('สำนักงานใหญ่ แยกขอบข่าย')
        console.log(lab_main_address)


        let propertyName = `pl_2_${globalTypeNumber}_main`;

        if (!Array.isArray(lab_main_address.lab_types[propertyName])) {
             lab_main_address.lab_types[propertyName] = []; // ถ้าไม่ใช่ ให้ตั้งเป็น array ว่าง
         }
     
         // คำนวณ index จากลำดับของ array เดิม
         let index = lab_main_address.lab_types[propertyName].length;
     
         let newEntry = {
             index: index,
             category: category_id,
             category_th: category_th,
             test_field: test_field_th,
             test_field_eng: test_field_eng,
             description: description,
             standard: standard,
             code: "2",
             measurements: test_measurementsCopy,
         };
     
         lab_test_scope_data_transaction.push(newEntry);

        // let propertyName = `pl_2_${globalTypeNumber}_main`;

        if (!Array.isArray(lab_main_address.lab_types[propertyName])) {
            lab_main_address.lab_types[propertyName] = [];
        }
        
        // ตรวจสอบข้อมูลใหม่ก่อนเพิ่ม
        // lab_test_scope_data_transaction = lab_test_scope_data_transaction.filter((entry, index, self) =>
        //     index === self.findIndex(e => e.index === entry.index && e.category === entry.category)
        // );

        // เพิ่มข้อมูลใหม่
        lab_main_address.lab_types[propertyName].push(...lab_test_scope_data_transaction);

        sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
        lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || [];

        // ล้างรายการชั่วคราว
        // lab_test_scope_data_transaction.length = 0;
        
        console.log(`อัปเดต ${propertyName} หลังเพิ่มข้อมูลใหม่:`, lab_main_address.lab_types[propertyName]);
        
    }

    test_measurements = [];

    renderTestScopeWithParameterTable()


    // ตั้งค่าให้ select2 กลับไปที่ค่า "-สาขาทดสอบ-"
    $('#test_main_branch').val(null).trigger('change');

    // ตั้งค่าให้ select2 ของ test_category กลับไปที่ค่า "-สาขาทดสอบ-" 
    $('#test_category').val(null).trigger('change');

    $('#test_parameter').prop('selectedIndex', 0);
    // ล้างค่าในฟอร์ม
    $('#test_parameter_desc').val('');
    $('#test_condition_description').val('');
    $('#test_param_detail_textarea').val('');
    $('#test_standard_txtarea').val('');
    
    $('#modal-add-test-scope').modal('hide');


    
});

function removeTestRow(index, key) {
    // ลบรายการออกจาก lab_cal_scope_data_transaction สำหรับ key ที่กำหนด
    lab_main_address.lab_types[key].splice(index, 1);
    sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
    lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || [];


    // เรียกฟังก์ชัน render ใหม่
    renderTestScopeWithParameterTable();
}

function removeBranchTestRow(index, key, branchIndex) {
    // ลบรายการออกจาก lab_test_scope_data_transaction ของสาขาที่กำหนด
    lab_addresses_array[branchIndex].lab_types[key].splice(index, 1);

    sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
 lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    // เรียกฟังก์ชัน render ใหม่
    renderTestScopeWithParameterTable();
}

function removeBranchCalRow(index, key, branchIndex) {
    // ลบรายการออกจาก lab_test_scope_data_transaction ของสาขาที่กำหนด
    lab_addresses_array[branchIndex].lab_types[key].splice(index, 1);

    sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
 lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    // เรียกฟังก์ชัน render ใหม่
    renderCalScopeWithParameterTable();
}

function renderTestScopeWithParameterTable() {

    lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || [];
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    // console.log('aha',lab_main_address)

    let wrapper = $('#scope_table_wrapper');
    wrapper.empty(); 

    let labTypes = lab_main_address.lab_types; 

    for (let i = 1; i <= 5; i++) { 
        let key = `pl_2_${i}_main`; 

        if (Array.isArray(labTypes[key])) { 
            console.log(`Key สำนักงานใหญ่ ที่เป็น array: ${key}`); 
            console.log(`ค่าของ ${key}:`, labTypes[key]); 

            let facilityType = mainFacilityTypes.find(type => type.id === key); 
            let labelText = facilityType ? facilityType.text : "ไม่ทราบประเภท"; 


            let lab_test_scope_data_transaction = labTypes[key];

            lab_test_scope_data_transaction.sort((a, b) => {
                if (a.category < b.category) return -1;
                if (a.category > b.category) return 1;
                return 0;
            });

            let categoryCounts = {};
            lab_test_scope_data_transaction.forEach(item => {
                if (!categoryCounts[item.category]) {
                    categoryCounts[item.category] = lab_test_scope_data_transaction.filter(scope => scope.category === item.category).length;
                }
            });

                    // จัดเรียงข้อมูลตาม category


            let renderedCategories = {}; 
            let previousCategory = null; // ตัวแปรเก็บค่า category ก่อนหน้า

            let tableContent = '';
            if (lab_test_scope_data_transaction && lab_test_scope_data_transaction.length > 0) {
               
                tableContent = `
                    <h5 class="text-primary">${labelText}</h5> 
                    <table class="table custom-bordered-table table-no-hover" id="test_scope_table_${key}">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center text-white">สาขาการทดสอบ</th>
                                <th class="text-center text-white">รายการทดสอบ</th>
                                <th class="text-center text-white">วิธีการที่ใช้</th>
                                <th class="text-center text-white">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
            }
           

            lab_test_scope_data_transaction.forEach((item, index) => {
                // ตรวจสอบว่า category ซ้ำกับค่าก่อนหน้าหรือไม่
                let isCategoryHidden = item.category === previousCategory;
            
                // อัปเดตค่า category ก่อนหน้า
                previousCategory = item.category;
            
                if (!isCategoryHidden) {
                    // หาก category ยังไม่ซ้ำ
                    tableContent += `
                        <tr>
                            <td style="">
                                <div style="font-weight:600">
                                    สาขา${item.category_th}

                                </div>   
                            </td>
                            <td style="">
                                <div style="visibility: hidden;">
                                    สาขา${item.category_th}
                                    <br>
                                    <span>(${item.category} field)</span>
                                </div> 
                            </td>
                            <td style="">
                                <div style="visibility: hidden;">
                                    สาขา${item.category_th}
                                    <br>
                                    <span>(${item.category} field)</span>
                                </div>
                            </td>
                              <td class="text-center">
                               
                            </td>
                        </tr>
                    `;
                }
            
                // ส่วนที่แสดงทุกครั้ง (test_field, measurements, standard)
                tableContent += `
                    <tr>
                        <td style="vertical-align: top;padding:5px;padding-left:10px;">
                            <div>
                                <span style="margin-left:10px">${item.test_field}</span>
                            </div>

                        </td>
                        <td style="vertical-align: top;padding:5px;">
                            <div>${item.measurements[0].name}</div>
                            <div>(${item.measurements[0].name_eng})</div>
                            ${item.measurements[0].detail ? `<div style="padding-left: 10px;">${item.measurements[0].detail}</div>` : ''}
                        </td>
                        <td style="vertical-align: top;padding:5px;">
                            <div>
                                <span>${item.standard}</span>
                            </div>
                        </td>
                         <td class="text-center">
                                <button class="btn btn-danger btn-sm" onclick="removeTestRow(${index}, '${key}')">ลบ</button>
                            </td>
                    </tr>
                `;
            });
            
            
            tableContent += `
                    </tbody>
                </table>
            `;

            wrapper.append(tableContent);

        }
    }

    if (Array.isArray(lab_addresses_array)) {
        for (let i = 0; i < lab_addresses_array.length; i++) {
            const branchLabType = lab_addresses_array[i].lab_types;
        
            // สร้าง header สำหรับแต่ละสาขา (แสดงครั้งเดียว)
            let header = `<h5 class="text-primary">สาขา${lab_addresses_array[i].address_district_add_modal}</h5>`;
            let tableWrapper = ""; // เก็บเนื้อหาของตารางทั้งหมดในแต่ละสาขา
        
            for (let j = 1; j <= 5; j++) { 
                let key = `pl_2_${j}_branch`; 
        
                if (Array.isArray(branchLabType[key])) { 
                    console.log(`Key สาขา ที่เป็น array: ${key}`); 
                    console.log(`ค่าของ ${key}:`, branchLabType[key]); 
        
                    let facilityType = branchFacilityTypes.find(type => type.id === key); 
                    let labelText = facilityType ? facilityType.text : "ไม่ทราบประเภท"; 
        
                    let lab_test_scope_data_transaction = branchLabType[key];
        
                    lab_test_scope_data_transaction.sort((a, b) => {
                        if (a.category < b.category) return -1;
                        if (a.category > b.category) return 1;
                        return 0;
                    });
    
                    let categoryCounts = {};
                    lab_test_scope_data_transaction.forEach(item => {
                        if (!categoryCounts[item.category]) {
                            categoryCounts[item.category] = lab_test_scope_data_transaction.filter(scope => scope.category === item.category).length;
                        }
                    });


                    let tableContent = '';
                    if (lab_test_scope_data_transaction && lab_test_scope_data_transaction.length > 0) {
                        tableContent = `
                        <h5 class="text-primary">${labelText}</h5> 
                        <table class="table custom-bordered-table table-no-hover" id="test_scope_table_${key}">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center text-white">สาขาการทดสอบ</th>
                                    <th class="text-center text-white">รายการทดสอบ</th>
                                    <th class="text-center text-white">วิธีการที่ใช้</th>
                                    <th class="text-center text-white">ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    }
        
                    
                    let previousCategory = null; // ตัวแปรเก็บค่า category ก่อนหน้า
                    lab_test_scope_data_transaction.forEach((item, index) => {
                        let isCategoryHidden = item.category === previousCategory;
                        previousCategory = item.category;
        
                        if (!isCategoryHidden) {
                            tableContent += `
                                <tr>
                                    <td>
                                        <div style="font-weight:600">
                                            สาขา${item.category_th}
                                        </div>
                                    </td>
                                    <td><div style="visibility: hidden;"></div></td>
                                    <td><div style="visibility: hidden;"></div></td>
                                    <td class="text-center"></td>
                                </tr>
                            `;
                        }
        
                        tableContent += `
                            <tr>
                                <td style="vertical-align: top;padding:5px;padding-left:10px;">
                                    <div>
                                        <span style="margin-left:10px">${item.test_field}</span>
                                    </div>
                                </td>
                                <td style="vertical-align: top;padding:5px;">
                                    <div>${item.measurements[0].name}</div>
                                    <div>(${item.measurements[0].name_eng})</div>
                                    ${item.measurements[0].detail ? `<div style="padding-left: 10px;">${item.measurements[0].detail}</div>` : ''}
                                </td>
                                <td style="vertical-align: top;padding:5px;">
                                    <div>
                                        <span>${item.standard}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm" onclick="removeBranchTestRow(${index}, '${key}', ${i})">ลบ</button>
                                </td>
                            </tr>
                        `;
                    });
        
                    tableContent += `
                            </tbody>
                        </table>
                    `;
        
                    tableWrapper += tableContent;
                }
            }
            // เพิ่ม header และ tableWrapper ใน wrapper ทีเดียว
            wrapper.append(header + tableWrapper);
        }
    }


    
};


$(document).on('change', '#select_certified', function() {
    var certified_id = $(this).val();
    const _token = $('input[name="_token"]').val();
    
    if (certified_id === '' || certified_id === undefined) {
        return;
    }
    
    $.ajax({
        url: "/certify/applicant/api/get_certificated",
        method: "POST",
        data: {
            certified_id: certified_id,
            _token: _token
        },
        success: function(result) {
            attach_path = result.attach_path;
            console.log(result.certiLab);
            console.log(result.certiLabInfo);
            var dis_title = result.address.original.dis_title;
            var dis_title_en = result.address.original.dis_title_en;
            var pro_id = result.address.original.pro_id;
            var sub_title = result.address.original.sub_title;
            var sub_title_en = result.address.original.sub_title_en;
            var zip_code = result.address.original.zip_code;
            
            $('#ref_application_no').val(result.certificateExport.request_number);
            $('#accereditation_no').val(result.certificateExport.accereditatio_no);
            $('#lab_name').val(result.certiLab.lab_name);
            $('#lab_name_en').val(result.certiLab.lab_name_en);
            $('#lab_name_short').val(result.certiLab.lab_name_short);
            $('#address_number').val(result.certiLab.address_no);
            $('#village_no').val(result.certiLab.allay);
            $('#address_soi').val(result.certiLab.village_no);
            $('#address_street').val(result.certiLab.road);

            $('#lab_address_no_eng').val(result.certiLab.lab_address_no_eng);
            $('#lab_moo_eng').val(result.certiLab.lab_moo_eng);
            $('#lab_soi_eng').val(result.certiLab.lab_soi_eng);
            $('#lab_street_eng').val(result.certiLab.lab_street_eng);

            $('#address_city').val(pro_id).trigger('change');
            $('#address_district').val(dis_title);
            $('#sub_district').val(sub_title);
            $('#postcode').val(zip_code);
            
            $('#lab_province_eng').val(pro_id).trigger('change');
            $('#lab_amphur_eng').val(dis_title_en);
            $('#lab_district_eng').val(sub_title_en);
            $('#lab_postcode_eng').val(zip_code);

            $('#lab_latitude').val(result.certiLab.lab_latitude);
            $('#lab_longitude').val(result.certiLab.lab_longitude);

            var certiLabPlace = result.certi_lab_place;

            labCalScopeTransactions = result.labCalScopeTransactions;
            branchLabAdresses = result.branchLabAdresses;


            // Update the checkboxes based on certiLabPlace values
           
            if (certiLabPlace) {
                $('#pl_2_1').iCheck(certiLabPlace.permanent_operating_site != null && certiLabPlace.permanent_operating_site == 0 ? 'check' : 'uncheck');
                $('#pl_2_2').iCheck(certiLabPlace.off_site_operations != null && certiLabPlace.off_site_operations == 0 ? 'check' : 'uncheck');
                $('#pl_2_3').iCheck(certiLabPlace.mobile_operating_facility != null && certiLabPlace.mobile_operating_facility == 0 ? 'check' : 'uncheck');
                $('#pl_2_4').iCheck(certiLabPlace.temporary_operating_site != null && certiLabPlace.temporary_operating_site == 0 ? 'check' : 'uncheck');
                $('#pl_2_5').iCheck(certiLabPlace.multi_site_facility != null && certiLabPlace.multi_site_facility == 0 ? 'check' : 'uncheck');

            }

            var managementLab = result.certiLab.management_lab;

            $('input[name="mn_3_1"][value="0"]').iCheck(managementLab == '0' ? 'check' : 'uncheck');
            $('input[name="mn_3_1"][value="1"]').iCheck(managementLab == '1' ? 'check' : 'uncheck');

            // สมมติว่าค่าของ petitionerLab มาจาก response
            var petitionerLab = result.certiLabInfo.petitioner;

            // ตั้งค่า select ให้เลือกค่า petitionerLab
            $('#man_applicant').val(petitionerLab).trigger('change');


            // $('#select_certified_temp').val(certified_id);
            $('#select_certified_temp').val(result.certificateExport.certificate_for).attr('value', result.certificateExport.certificate_for);
            $('#select_certified_temp_1').val(result.certificateExport.certificate_for).attr('value', result.certificateExport.certificate_for);

            $('#repeater_section4_wrapper').empty();

            $('#repeater_section4_wrapper').empty();


       

            // Render section 5 files similarly
            renderFiles(result.file_sectionn4s, '#repeater_section4_wrapper', '4');
            $('.attachs_sec4').removeAttr('required');

            renderFiles(result.file_sectionn5s, '#repeater_section5_wrapper', '5');
            $('.attachs_sec5').removeAttr('required');

            renderFiles(result.file_sectionn71s, '#repeater_section71_wrapper', '71');
            $('.attachs_sec71').removeAttr('required');

            renderFiles(result.file_sectionn72s, '#repeater_section72_wrapper', '72');
            $('.attachs_sec72').removeAttr('required');

            renderFiles(result.file_sectionn8s, '#repeater_section8_wrapper', '8');
            $('.attachs_sec8').removeAttr('required');

            renderFiles(result.file_sectionn9s, '#repeater_section9_wrapper', '9');
            $('.attachs_sec9').removeAttr('required');
            
            renderFiles(result.file_sectionn10s, '#repeater_section10_wrapper', '10');
            $('.attachs_sec10').removeAttr('required');

            renderOtherFiles(result.file_others, '#repeater_section_other_wrapper');
            $('.another_attach_files').removeAttr('required');

            console.log("หน้า ajax  จากฐานข้อมูล")
            // console.log(labCalScopeTransactions.filter(item => item.branch_lab_adress_id === null));
            const labCalScopeMainTransactions = labCalScopeTransactions.filter(item => item.branch_lab_adress_id === null);
                const lab_main_address_server = {
                    lab_type: 'main',
                    checkbox_main: '1',
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
                    lab_types: createLabTypesFromServer(labCalScopeMainTransactions,null,"main"), // เรียกใช้ฟังก์ชันเพื่อสร้าง lab_types
                    address_soi_add: "",
                    address_street_add: ""
                };
    
                lab_main_address = lab_main_address_server;
    
                console.log(lab_main_address);
    
                sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address_server));
    
                checkAllCheckboxes();
    
                lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address'));
                console.log('after load from server');
                console.log(lab_main_address);
    
                const labCalScopeBranchTransactions  = labCalScopeTransactions.filter(item => item.branch_lab_adress_id !== null);
    
                console.log('filter');
                // console.log(labCalScopeBranchTransactions);
                const branchAddresses = [];
                console.log(branchLabAdresses);
                branchLabAdresses.forEach(branchItem => {
                    // console.log('branchItem.postal');
                    // console.log(branchItem.postal);
                    const lab_branch_address_server = {
                        lab_type: 'branch',
                        checkbox_main: '1',
    
                        // thai
                        address_number_add_modal: branchItem.addr_no || "",
                        village_no_add_modal: branchItem.addr_moo || "",
                        soi_add_modal: branchItem.addr_soi || "",
                        road_add_modal: branchItem.addr_road || "",
                       
                        // จังหวัด
                        address_city_add_modal: branchItem.province.PROVINCE_ID || "",
                        address_city_text_add_modal: branchItem.province.PROVINCE_NAME || "",
                        // อำเภอ
                        address_district_add_modal: branchItem.amphur.AMPHUR_NAME || "",
                        address_district_add_modal_id: branchItem.amphur.AMPHUR_ID || "",
                        // ตำบล
                        sub_district_add_modal: branchItem.district.DISTRICT_NAME || "",
                        sub_district_add_modal_id: branchItem.district.DISTRICT_ID || "",
                        // รหัสไปรษณีย์
                        postcode_add_modal: branchItem.postal || "",
    
                        // eng
                        lab_address_no_eng_add_modal: branchItem.addr_no || "",
                        lab_moo_eng_add_modal: branchItem.addr_moo_en || "",
                        lab_soi_eng_add_modal: branchItem.addr_soi_en || "",
                        lab_street_eng_add_modal: branchItem.addr_road_en || "",
    
                        lab_province_eng_add_modal: branchItem.province.PROVINCE_ID || "",
                        // อำเภอ
                        lab_amphur_eng_add_modal: branchItem.amphur.AMPHUR_NAME_EN || "",
                        // ตำบล
                        lab_district_eng_add_modal: branchItem.district.DISTRICT_NAME_EN || "",
                       
                        lab_types: createLabTypesFromServer(labCalScopeBranchTransactions, branchItem.id, "branch"), // สำหรับสาขา
                    };
    
                    branchAddresses.push(lab_branch_address_server);
                           
                });
    
                sessionStorage.setItem('lab_addresses_array', JSON.stringify(branchAddresses));

                // ดึงข้อมูลจาก session storage เมื่อเอกสารถูกโหลด
                lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    
                console.log('lab_addresses_array loaded');            
                console.log(lab_addresses_array);
    
                // ถ้ามีข้อมูลใน session storage ให้ render ในตาราง
                if (lab_addresses_array.length > 0) {
                    renderTable(lab_addresses_array);
                }
                   



        }
    });
});

function renderFiles(files, wrapperSelector, section) {
    var wrapper = $(wrapperSelector);
    wrapper.empty(); // ล้างข้อมูลเก่าออก

    // if (files.length > 0) {
    //     files.forEach(function(file) {
    //         var fileItem = `
    //             <div class="form-group">
    //                 <div class="col-md-4 text-light"></div>
    //                 <div class="col-md-6">
    //                     <a href="${baseUrl}uploads/${attach_path}${file.file}" target="_blank" class="view-attach btn btn-info btn-sm">
    //                         ${file.file_client_name}
    //                     </a>
    //                     <a href="/certify/applicant/delete/file_app_certi_lab_attach_all/${file.id}" 
    //                        class="btn btn-danger btn-xs box_remove_file" 
    //                        onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
    //                         <i class="fa fa-remove"></i>
    //                     </a>
    //                 </div>
    //             </div>
    //         `;
    //         wrapper.append(fileItem);
    //     });
    // }

    if (files.length > 0) {
        files.forEach(function(file) {
            var fileItem = `
                <div class="form-group">
                    <div class="col-md-4 text-light"></div>
                    <div class="col-md-6">
                        <a href="${baseUrl}uploads/${attach_path}${file.file}" target="_blank" class="view-attach btn btn-info btn-sm">
                            <i class="fa fa-eye mr-2"></i> ${file.file_client_name}
                        </a>
                    </div>
                </div>
            `;
            wrapper.append(fileItem);
        });
    }

    // Add default file input for uploading new files
    var newFileInput = `
        <div class="form-group box_remove_file" data-repeater-item>
            <div class="col-md-4 text-light"></div>
            <div class="col-md-6">
                <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">เลือกไฟล์</span>
                        <span class="fileinput-exists">เปลี่ยน</span>
                        <input type="file" name="repeater-section${section}[0][attachs_sec${section}]" class="attachs_sec${section} check_max_size_file" required>
                    </span> 
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                </div>
                <p class="help-block"></p>
            </div>
      
        </div>
    `;
    wrapper.append(newFileInput);
}

function renderOtherFiles(files, container) {
    // Clear the current content in the container
    $(container).empty();

    // Check if there are existing files to render
    // if (files && files.length > 0) {
    //     files.forEach(function(file) {
    //         // Generate HTML for each existing file
    //         let existingFileHtml = `
    //             <div class="form-group">
    //                 <div class="col-md-4 text-light">
    //                     <input type="text" class='form-control' value="${file.file_desc ? file.file_desc : ''}" disabled>
    //                 </div>
    //                 <div class="col-md-6">
    //                     <a href="${baseUrl}uploads/${attach_path}${file.file}" target="_blank" class="view-attach btn btn-info btn-sm">${file.file_client_name}</a>
    //                     <a href="${file.delete_url}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')" disabled>
    //                         <i class="fa fa-remove"></i>
    //                     </a>
    //                 </div>
    //             </div>`;
    //         $(container).append(existingFileHtml);
    //     });
    // }

    if (files && files.length > 0) {
        files.forEach(function(file) {
            // Generate HTML for each existing file
            let existingFileHtml = `
                <div class="form-group">
                    <div class="col-md-4 text-light">
                        <input type="text" class='form-control' value="${file.file_desc ? file.file_desc : ''}" disabled>
                    </div>
                    <div class="col-md-6">
                        <a href="${baseUrl}uploads/${attach_path}${file.file}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-eye mr-2"></i> ${file.file_client_name}</a>
                    </div>
                </div>`;
            $(container).append(existingFileHtml);
        });
    }

    // Append the repeater template for adding new files
    let newFileTemplate = `
        <div class="form-group box_remove_file" data-repeater-item>
            <div class="col-md-4 text-light">
                <input type="text" name="another_attach_files_desc" class="form-control" placeholder="กรุณากรอกชื่อไฟล์">
            </div>
            <div class="col-md-6">
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">เลือกไฟล์</span>
                        <span class="fileinput-exists">เปลี่ยน</span>
                        <input type="file" name="repeater-section-other[0][another_attach_files]" class="another_attach_files check_max_size_file">
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                </div>
            </div>

        </div>`;
    $(container).append(newFileTemplate);
}



function resetFields() {
    $('#ref_application_no').val('');
    $('#accereditation_no').val('');
    $('#lab_name').val('');
    $('#lab_name_en').val('');
    $('#lab_name_short').val('');
    $('#address_number').val('');
    $('#village_no').val('');
    $('#address_soi').val('');
    $('#address_street').val('');

    $('#lab_address_no_eng').val('');
    $('#lab_moo_eng').val('');
    $('#lab_soi_eng').val('');
    $('#lab_street_eng').val('');
    // 

    // Set to the first option of the select
    // resetCertifiedSelect();
    $('#address_district').val('');
    $('#sub_district').val('');
    $('#postcode').val('');

    // Set to the first option of the select
    $('#lab_province_eng').val($('#lab_province_eng option:first').val()).trigger('change');
    $('#lab_amphur_eng').val('');
    $('#lab_district_eng').val('');
    $('#lab_postcode_eng').val('');

    $('#lab_latitude').val('');
    $('#lab_longitude').val('');
    $('#select_certified_temp').val('');
}

// Function to clear and rebuild select_certified
function resetCertifiedSelect() {
    // Clear all options in the select_certified
    $('#select_certified').empty();

    // Add default option back
    $('#select_certified').append('<option value="">- เลือกใบรับรอง -</option>');

    // Loop through certifieds object and create options
    $.each(certifieds, function(id, certificate_no) {
        $('#select_certified').append('<option value="' + id + '">' + certificate_no + '</option>');
    });

    // Reinitialize select (if using any custom select plugin like Select2)
    $('#select_certified').trigger('change');
}





$(document).on('change', '#cal_instrumentgroup', function() {
    var calibration_branch_instrument_group_id = $(this).val();
    const _token = $('input[name="_token"]').val();
    $('#cal_parameter_one_wrapper').hide();
    $('#cal_parameter_two_wrapper').hide();
    $('#cal_parameters_wrapper').hide();
    $('#cal_infomation_scope').hide();

    $.ajax({
        url: "/certify/applicant/api/instrument",
        method: "POST",
        data: {
            calibration_branch_instrument_group_id: calibration_branch_instrument_group_id,
            _token: _token
        },
        success: function (result) {
            // ตรวจสอบและแสดงหรือซ่อน wrapper ตามผลลัพธ์

            $('#cal_instrument').select2('destroy').empty();
            $('#cal_instrument').select2();

            $('#cal_parameters').select2('destroy').empty();
            $('#cal_parameters').select2();

            $('#cal_parameter_one').select2('destroy').empty();
            $('#cal_parameter_one').select2();

            $('#cal_parameter_two').select2('destroy').empty();
            $('#cal_parameter_two').select2();

         


            if (result.instrument && result.instrument.length > 0) {
                $('#cal_instrument_wrapper').show();

                // Destroy and clear the select2 instance and options for #cal_instrument
                // $('#cal_instrument').select2('destroy').empty();
                $('#cal_instrument').append('<option value="not_select" disabled selected>- เลือกเครื่องมือ2 -</option>');

                $.each(result.instrument, function (index, value) {
                    $('#cal_instrument').append('<option value=' + value.id + '>' + value.name + '</option>');
                });

            } else {

                $('#cal_instrument_wrapper').hide();
            }


            // if (result.parameter_one && result.parameter_one.length > 0) {
            //     $('#cal_parameter_one_wrapper').show();

            //     $('#cal_parameter_one').append('<option value="not_select" disabled selected>- เลือกพารามิเตอร์1 -</option>');

            //     $.each(result.parameter_one, function (index, value) {
            //         $('#cal_parameter_one').append('<option value=' + value.id + '>' + value.name + '</option>');
            //     });

            // } else {
            //     $('#cal_parameter_one_wrapper').hide();
            //     $('#add_parameter_one_button').remove(); 
            // }

            // if (result.parameter_two && result.parameter_two.length > 0) {
            //     $('#cal_parameter_two_wrapper').show();
            
            //     // Clear existing options and append default option
            //     $('#cal_parameter_two').html('<option value="not_select" disabled selected>- เลือกพารามิเตอร์2 -</option>');
            
            //     // Append options dynamically from result
            //     $.each(result.parameter_two, function (index, value) {
            //         $('#cal_parameter_two').append('<option value=' + value.id + '>' + value.name + '</option>');
            //     });
            
            // } else {
            //     $('#cal_parameter_two_wrapper').hide();
            //     $('#add_parameter_two_button').remove(); // Remove button if no parameters
            // }

            
            // ซ่อน cal_parameters_wrapper ไว้ก่อน
            $('#cal_parameters_wrapper').hide();

            // ลบข้อมูลเก่าใน #cal_parameters
            $('#cal_parameters').empty();


            
            // ตรวจสอบและจัดการ parameter_one
            if (result.parameter_one && result.parameter_one.length > 0) {
                
                $('#cal_parameter_one').html('<option value="not_select" disabled selected>- เลือกพารามิเตอร์1 -</option>');

                $.each(result.parameter_one, function (index, value) {
                    $('#cal_parameter_one').append('<option value=' + value.id + '>' + value.name + '</option>');
                });
                // alert('ok');
                // เพิ่ม "พารามิเตอร์1" ใน #cal_parameters
                $('#cal_parameters').append('<option value="parameter_one">พารามิเตอร์1</option>');
            } 

            // ตรวจสอบและจัดการ parameter_two
            if (result.parameter_two && result.parameter_two.length > 0) {
                
                $('#cal_parameter_two').html('<option value="not_select" disabled selected>- เลือกพารามิเตอร์2 -</option>');

                $.each(result.parameter_two, function (index, value) {
                    $('#cal_parameter_two').append('<option value=' + value.id + '>' + value.name + '</option>');
                });

                // เพิ่ม "พารามิเตอร์2" ใน #cal_parameters
                $('#cal_parameters').append('<option value="parameter_two">พารามิเตอร์2</option>');
            } 

            // แสดง cal_parameters_wrapper หากมี parameter_one หรือ parameter_two
            if ((result.parameter_one && result.parameter_one.length > 0) || 
                (result.parameter_two && result.parameter_two.length > 0)) {
                $('#cal_parameters_wrapper').show();
            }


            $('#cal_parameters').trigger('change'); // เรียกใช้งาน event change ทันที

            // เพิ่มการเปลี่ยนแปลงใน #cal_parameters
            $('#cal_parameters').on('change', function () {
                
                const selectedValue = $(this).val();
                console.log(selectedValue);

                // ซ่อน wrapper ทั้งหมดก่อน
                $('#cal_parameter_one_wrapper').hide();
                $('#cal_parameter_two_wrapper').hide();
                $('#cal_infomation_scope').hide();

                // แสดง wrapper ตามตัวเลือก
                if (selectedValue === 'parameter_one') {
                    $('#cal_parameter_one_wrapper').show();
                } else if (selectedValue === 'parameter_two') {
                    $('#cal_parameter_two_wrapper').show();
                }


            });

            // เพิ่มการเปลี่ยนแปลงใน #cal_parameters
            $('#cal_parameter_one').on('change', function () {
                $('#cal_infomation_scope').show();
                measurements = [];
                let parameterName = $(this).find(':selected').text();
                let parameterType = $(this).val(); // ประเภทพารามิเตอร์ที่เลือก
             
                // ตรวจสอบว่า parameter นี้มีอยู่แล้วหรือยัง
                let existingMeasurement = measurements.find(measurement => measurement.name === parameterName);
            
                if (!existingMeasurement) {
                    // หากยังไม่มี ให้เพิ่มเข้าไปใน measurements
                    measurements.push({
                        name: parameterName,
                        type: parameterType,
                        ranges: [] // อาร์เรย์สำหรับเก็บ ranges ของ parameter นี้
                    });
                } else {
                    // หากมีอยู่แล้ว ให้ปรับปรุงประเภท (type)
                    existingMeasurement.type = parameterType;
                }
                console.log(measurements)
                renderParamCMCTable()
            });

            // $('#cal_parameters').on('change', function () {
            //     $('#cal_infomation_scope').hide();
            // });


            $('#cal_parameter_two').on('change', function () {
                $('#cal_infomation_scope').show();
                measurements = [];
                let parameterName = $(this).find(':selected').text();
                let parameterType = $(this).val(); // ประเภทพารามิเตอร์ที่เลือก
             
                // ตรวจสอบว่า parameter นี้มีอยู่แล้วหรือยัง
                let existingMeasurement = measurements.find(measurement => measurement.name === parameterName);
            
                if (!existingMeasurement) {
                    // หากยังไม่มี ให้เพิ่มเข้าไปใน measurements
                    measurements.push({
                        name: parameterName,
                        type: parameterType,
                        ranges: [] // อาร์เรย์สำหรับเก็บ ranges ของ parameter นี้
                    });
                } else {
                    // หากมีอยู่แล้ว ให้ปรับปรุงประเภท (type)
                    existingMeasurement.type = parameterType;
                }
                console.log(measurements)
                renderParamCMCTable()
            });

            $('#cal_instrument').on('change', function () {
                // $('#cal_infomation_scope').show();
            });



            $("input[name='cal_param_option']").on("ifChanged", function() {
                var selectedOption = $(this).val(); // ค่า radio ที่ถูกเลือก
                console.log(selectedOption); // แสดงค่าที่ถูกเลือกใน console
                
                // ซ่อนทุกๆ ส่วนที่เกี่ยวข้องก่อน
                $('#cal_param_range_textarea').hide();
                $('#cal_param_file').hide();
                
                // แสดงส่วนตามตัวเลือก
                if (selectedOption === 'text') {
                    $('#cal_param_range_textarea').show(); // แสดง textarea
                    $('#cal_param_file').hide(); 
            
                    // ลบไฟล์ที่ค้างอยู่ใน input file ถ้าเลือกข้อความ
                    $('#cal_param_file').val(''); // Clear ไฟล์ที่เลือก
                } else if (selectedOption === 'picture') {
                    $('#cal_param_file').show(); // แสดง input สำหรับเลือกไฟล์
                    $('#cal_param_range_textarea').hide(); // ซ่อน textarea
            
                    // ล้างค่าใน textarea ถ้าเลือกไฟล์
                    $('#cal_param_range_textarea').val(''); // Clear ค่าใน textarea
                }
            });


            $("input[name='cal_cmc_option']").on("ifChanged", function() {
                var selectedOption = $(this).val(); // ค่า radio ที่ถูกเลือก
                console.log(selectedOption); // แสดงค่าที่ถูกเลือกใน console
                
                // ซ่อนทุกๆ ส่วนที่เกี่ยวข้องก่อน
                $('#cal_cmc_uncertainty_textarea').hide();
                $('#cal_cmc_file').hide();
                
                // แสดงส่วนตามตัวเลือก
                if (selectedOption === 'text') {
                    $('#cal_cmc_uncertainty_textarea').show(); // แสดง textarea
                    $('#cal_cmc_file').hide(); 
            
                    // ลบไฟล์ที่ค้างอยู่ใน input file ถ้าเลือกข้อความ
                    $('#cal_cmc_file').val(''); // Clear ไฟล์ที่เลือก
                } else if (selectedOption === 'picture') {
                    $('#cal_cmc_file').show(); // แสดง input สำหรับเลือกไฟล์
                    $('#cal_cmc_uncertainty_textarea').hide(); // ซ่อน textarea
            
                    // ล้างค่าใน textarea ถ้าเลือกไฟล์
                    $('#cal_cmc_uncertainty_textarea').val(''); // Clear ค่าใน textarea
                }
            });

            $('#show_modal_add_parameter_symbol').on('click', function () {
                $('#modal-add-cal-parameter-symbol').modal('show');
            });

            $('#show_modal_add_cmc_symbol').on('click', function () {
                $('#modal-add-cal-cmc-symbol').modal('show');
            });

            $('#button_add_cal_param_cmc').on('click', function () {
                $('#modal-add-cal-param-cmc').modal('show');
            });
            
        }
    });
});

$('#modal-add-cal-parameter-symbol').on('hidden.bs.modal', function () {
    if ($('.modal:visible').length) {
        // หากมี modal ตัวอื่นเปิดอยู่ ให้คืนค่า scroll ให้กับ body
        $('body').addClass('modal-open');
    }
});

$('#modal-add-cal-cmc-symbol').on('hidden.bs.modal', function () {
    if ($('.modal:visible').length) {
        // หากมี modal ตัวอื่นเปิดอยู่ ให้คืนค่า scroll ให้กับ body
        $('body').addClass('modal-open');
    }
});

$('#modal-add-cal-param-cmc').on('hidden.bs.modal', function () {
    if ($('.modal:visible').length) {
        // หากมี modal ตัวอื่นเปิดอยู่ ให้คืนค่า scroll ให้กับ body
        $('body').addClass('modal-open');
    }
});

// Event handler for button click to show the modal
$(document).on('click', '#add_parameter_one_button', function () {
    // Show the modal
    $('#modal-create-parameter-one').modal('show'); 
});

// Ensure that the scroll and modal behaviors return to normal when the modal is hidden
$('#modal-create-parameter-one').on('hidden.bs.modal', function () {
    // Remove any changes made by the modal if necessary (e.g., cleanup variables or reset states)
    console.log('Modal closed, ready for next interaction.');
});


$('#button_add_cal_scope').on('click', function () {
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    // test_measurements = [];
    lab_cal_scope_data_transaction = [];
    // ดึงค่าจากฟอร์ม
    let category = $('#cal_main_branch').val(); // ID: cal_main_branch
    let category_th = $('#cal_main_branch option:selected').text(); // Text ของ option
    let instrument = $('#cal_instrumentgroup').val(); // ID: cal_instrumentgroup
    let instrument_text = $('#cal_instrumentgroup option:selected').text();
    let instrument_two = $('#cal_instrument').val(); // ID: cal_instrument
    let instrument_two_text = $('#cal_instrument option:selected').text();
    let description = $('#parameter_desc').val(); // ID: parameter_desc
    let standard = $('#cal_standard_txtarea').val(); // ID: cal_standard_txtarea
    let code = "2"; // ค่าคงที่ตามที่ระบุ

    if (!category || category === "") {
        alert('กรุณาเลือกสาขาสอบเทียบ');
        return;  // หยุดการทำงานที่เหลือ
    }

    if (!instrument || instrument === "") {
        alert('กรุณาเลือกเครื่องมือ1');
        return;  // หยุดการทำงานที่เหลือ
    }

    let measurementsCopy = JSON.parse(JSON.stringify(measurements)); // คัดลอกค่า measurements ปัจจุบัน

    // แสดงข้อมูลในคอนโซล
    console.log("measurements:", measurements);

    if (globalTypeNumber !== undefined && globalBranchNumber !== undefined) {
        console.log('สาขาแยกขอบข่าย');

        let propertyName = `pl_2_${globalTypeNumber}_branch`;

        console.log(lab_addresses_array[globalBranchNumber].lab_types[propertyName])
        
        // ตรวจสอบว่า `propertyName` เป็น array หรือไม่
        if (!Array.isArray(lab_addresses_array[globalBranchNumber].lab_types[propertyName])) {
            lab_addresses_array[globalBranchNumber].lab_types[propertyName] = []; // ถ้าไม่ใช่ ให้ตั้งเป็น array ว่าง
        }

        // คำนวณ index จากลำดับของ array เดิม
        let index = lab_addresses_array[globalBranchNumber].lab_types[propertyName].length;

        // สร้างรายการใหม่
        let newEntry = {
            index: index,
            category: category,
            category_th: category_th,
            instrument: instrument,
            instrument_text: instrument_text,
            instrument_two: instrument_two,
            instrument_two_text: instrument_two_text,
            description: description,
            standard: standard,
            code: code,
            measurements: measurementsCopy,
        };

            // เพิ่มข้อมูลใหม่ใน lab_cal_scope_data_transaction
        lab_cal_scope_data_transaction.push(newEntry);

        lab_addresses_array[globalBranchNumber].lab_types[propertyName].push(newEntry)

        sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
        lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

        console.log('lab_addresses_array',lab_addresses_array);


    } else if (globalTypeNumber === undefined && globalBranchNumber !== undefined ) {
        console.log('สาขาขอบข่ายร่วม');
    }else if(globalTypeNumber === undefined && globalBranchNumber === undefined ){
        console.log('สำนักงานใหญ่ขอบข่ายร่วม')
    }else if(globalTypeNumber !== undefined && globalBranchNumber === undefined ){
        console.log('สำนักงานใหญ่ แยกขอบข่าย')

        // ค่า stationType ที่ต้องการ
        let propertyName = `pl_2_${globalTypeNumber}_main`;

        // ตรวจสอบว่า `propertyName` เป็น array หรือไม่
        if (!Array.isArray(lab_main_address.lab_types[propertyName])) {
            lab_main_address.lab_types[propertyName] = []; // ถ้าไม่ใช่ ให้ตั้งเป็น array ว่าง
        }

        // คำนวณ index จากลำดับของ array เดิม
        let index = lab_main_address.lab_types[propertyName].length;

        // สร้างรายการใหม่
        let newEntry = {
            index: index,
            category: category,
            category_th: category_th,
            instrument: instrument,
            instrument_text: instrument_text,
            instrument_two: instrument_two,
            instrument_two_text: instrument_two_text,
            description: description,
            standard: standard,
            code: code,
            measurements: measurementsCopy,
        };

        // เพิ่มข้อมูลใหม่ใน lab_cal_scope_data_transaction
        lab_cal_scope_data_transaction.push(newEntry);

        if (!Array.isArray(lab_main_address.lab_types[propertyName])) {
            lab_main_address.lab_types[propertyName] = [];
        }

        lab_main_address.lab_types[propertyName].push(newEntry);
       
        sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
        lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || [];

        console.log(`หลังเพิ่มข้อมูลใหม่:`, lab_main_address); 
    }

    // ล้างค่าในฟอร์ม
    $('#parameter_desc').val('');
    $('#cal_standard_txtarea').val('');
    $('#cal_main_branch').prop('selectedIndex', 0);
    $('#cal_instrumentgroup').prop('selectedIndex', 0);
    $('#cal_instrument').prop('selectedIndex', 0);
    $('#cal_parameters').prop('selectedIndex', 0);

    // ซ่อนและรีเซ็ตส่วนที่เกี่ยวข้อง
    $('#cal_parameter_one_wrapper').hide();
    $('#cal_parameter_two_wrapper').hide();
    $('#cal_infomation_scope').hide();

    // รีเซ็ต measurements
    measurements = [];

    renderCalScopeWithParameterTable()

    $('#modal-add-cal-scope').modal('hide');


});

// function renderCalScopeWithParameterTable() {
//     let tbody = $('#cal_scope_table_body');
//     tbody.empty(); // ล้างข้อมูลเก่าก่อน

//     // สร้างตัวแปรสำหรับนับ category
//     let categoryCounts = {};
//     lab_cal_scope_data_transaction.forEach(item => {
//         if (!categoryCounts[item.category]) {
//             categoryCounts[item.category] = lab_cal_scope_data_transaction.filter(scope => scope.category === item.category).length;
//         }
//     });

//     let renderedCategories = {};

//     lab_cal_scope_data_transaction.forEach((item, index) => {
//         let isFirstOccurrence = !renderedCategories[item.category];
//         if (isFirstOccurrence) {
//             renderedCategories[item.category] = true;
//         }

//         let row = `
//             <tr>
//                 ${isFirstOccurrence ? `<td rowspan="${categoryCounts[item.category]}" style="vertical-align: top;">${item.category_th}</td>` : ''}
//                 <td>
//                     <div>${item.instrument_text}</div>
//                     <div style="margin-left: 15px;">
//                         ${item.description ? `<div>${item.description}</div>` : ''}
//                         <div style="${item.description ? 'margin-left: 15px;' : ''}">
//                             ${item.measurements.map(measurement => `
//                                 <div>${measurement.name}</div>
//                                 <div style="margin-left: 15px;">
//                                     ${measurement.ranges.map(range => `
//                                         <div>${range.description || ''}</div>
//                                         ${/\.(png|jpg|jpeg|gif)$/i.test(range.range) ? 
//                                             `<img src="${range.range}" alt="Image" style="width: 300px;" />` : 
//                                             `<div style="margin-left: 15px;">
//                                                 ${range.range ? range.range.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
//                                             </div>`
//                                         }
//                                     `).join('')}
//                                 </div>
//                             `).join('')}
//                         </div>
//                     </div>
//                 </td>
//                 <td>
//                     <div style="margin-left: 15px;">
//                         ${item.measurements.map(measurement => `
//                             <div>${measurement.ranges.map(range => `
//                                 <div>
//                                     ${range.uncertainty ? range.uncertainty.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
//                                 </div>
//                             `).join('')}</div>
//                         `).join('')}
//                     </div>
//                 </td>
//                 <td>
//                     <div style="margin-left: 15px;">
//                         ${item.measurements.map(measurement => `
//                             <div>
//                                 ${item.standard ? item.standard.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
//                             </div>
//                         `).join('')}
//                     </div>
//                 </td>
//                 <td>
//                     <button class="btn btn-danger btn-sm" onclick="removeRow(${index})">ลบ</button>
//                 </td>
//             </tr>
//         `;
//         tbody.append(row);
//     });
// }

// function renderCalScopeWithParameterTable() {

//     // let labTypes = lab_main_address.lab_types; // ดึง lab_types ออกมา

//     // for (let i = 1; i <= 5; i++) { // วนลูปตั้งแต่ 1 ถึง 5
//     //     let key = `pl_2_${i}_main`; // สร้างชื่อ key เช่น pl_2_1_main, pl_2_2_main
//     //     if (Array.isArray(labTypes[key])) { // ตรวจสอบว่าค่าเป็น array หรือไม่
//     //         console.log(`Key ที่เป็น array: ${key}`); // แสดง key ที่เป็น array
//     //         console.log(`ค่าของ ${key}:`, labTypes[key]); // ดึงค่าของคีย์ที่เป็น array ออกมา
//     //     }
//     // }

//     let tbody = $('#cal_scope_table_body');
//     tbody.empty(); // ล้างข้อมูลเก่าก่อน

//     // สร้างตัวแปรสำหรับนับ category
//     let categoryCounts = {};
//     lab_cal_scope_data_transaction.forEach(item => {
//         if (!categoryCounts[item.category]) {
//             categoryCounts[item.category] = lab_cal_scope_data_transaction.filter(scope => scope.category === item.category).length;
//         }
//     });

//     let renderedCategories = {};

//     lab_cal_scope_data_transaction.forEach((item, index) => {
//         let isFirstOccurrence = !renderedCategories[item.category];
//         if (isFirstOccurrence) {
//             renderedCategories[item.category] = true;
//         }

//     let formattedDescription = item.description
//         .replace(/ /g, '&nbsp;')   // แปลงช่องว่างเป็น &nbsp;
//         .replace(/\t/g, '&emsp;')  // แปลง \t เป็น &emsp; สำหรับแท็บ
//         .replace(/\n/g, '<br>');   // แปลง \n เป็น <br> สำหรับขึ้นบรรทัดใหม่

//         let row = `
//             <tr>
//                 ${isFirstOccurrence ? `<td rowspan="${categoryCounts[item.category]}" style="vertical-align: top;">${item.category_th}</td>` : ''}
//                 <td>
//                     <div>${item.instrument_text}</div>
//                     <div style="margin-left: 15px;">
//                         ${formattedDescription ? `<div style="white-space: pre-wrap;">${formattedDescription}</div>` : ''}
//                         <div style="${formattedDescription ? 'margin-left: 15px;' : ''}">
//                             ${item.measurements.map(measurement => `
//                                 <div>${measurement.name}</div>
//                                 <div style="margin-left: 15px;">
//                                     ${measurement.ranges.map(range => {
//                                         // ฟังก์ชันที่แปลง description
//                                         let formattedRangeDescription = range.description
//                                             .replace(/ /g, '&nbsp;')   // แปลงช่องว่างเป็น &nbsp;
//                                             .replace(/\t/g, '&emsp;')  // แปลง \t เป็น &emsp; สำหรับแท็บ
//                                             .replace(/\n/g, '<br>');   // แปลง \n เป็น <br> สำหรับขึ้นบรรทัดใหม่
                                        
//                                         return `
//                                             <div>${formattedRangeDescription || ''}</div>
//                                             ${/\.(png|jpg|jpeg|gif)$/i.test(range.range) ? 
//                                                 `<img src="${range.range}" alt="Image" style="width: 300px;" />` : 
//                                                 `<div style="margin-left: 15px;">
//                                                     ${range.range ? range.range.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
//                                                 </div>`
//                                             }
//                                         `;
//                                     }).join('')}
//                                 </div>
//                             `).join('')}
//                         </div>
//                     </div>
//                 </td>
//                 <td>
//                     <div style="visibility: hidden;">${item.instrument_text}</div>
//                     <div style="margin-left: 15px;">
//                         ${formattedDescription ? `<div style="visibility: hidden;white-space: pre-wrap;">${formattedDescription}</div>` : ''}
//                         <div style="${formattedDescription ? 'margin-left: 15px;' : ''}">
//                             ${item.measurements.map(measurement => `
//                                 <div style="visibility: hidden;">${measurement.name}</div>
//                                 <div style="margin-left: 15px;">
//                                     ${measurement.ranges.map(range => {
//                                         // ฟังก์ชันที่แปลง description
//                                         let formattedRangeDescription = range.description
//                                             .replace(/ /g, '&nbsp;')   // แปลงช่องว่างเป็น &nbsp;
//                                             .replace(/\t/g, '&emsp;')  // แปลง \t เป็น &emsp; สำหรับแท็บ
//                                             .replace(/\n/g, '<br>');   // แปลง \n เป็น <br> สำหรับขึ้นบรรทัดใหม่
                                        
//                                         return `
//                                             <div style="visibility: hidden">${formattedRangeDescription || ''}</div>
//                                             ${/\.(png|jpg|jpeg|gif)$/i.test(range.uncertainty) ? 
//                                                 `<img src="${range.uncertainty}" alt="Image" style="width: 300px;" />` : 
//                                                 `<div style="margin-left: 15px;">
//                                                     ${range.uncertainty ? range.uncertainty.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
//                                                 </div>`
//                                             }
//                                         `;
//                                     }).join('')}
//                                 </div>
//                             `).join('')}
//                         </div>
//                     </div>
//                 </td>
//                 <td>
//                     <div  style="visibility: hidden;">${item.instrument_text}</div>
//                     <div style="margin-left: 15px;">
//                         ${formattedDescription ? `<div  style="visibility: hidden;white-space: pre-wrap;">${formattedDescription}</div>` : ''}
//                         <div style="${formattedDescription ? 'margin-left: 15px;' : ''}">
//                             ${item.measurements.map(measurement => `
//                                 <div style="margin-left: 15px;">
//                                     ${item.measurements.map(measurement => `
//                                         <div>
//                                             ${item.standard ? item.standard.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
//                                         </div>
//                                     `).join('')}
//                                 </div>
//                                 <div style="margin-left: 15px;">
//                                     ${measurement.ranges.map(range => {
//                                         // ฟังก์ชันที่แปลง description
//                                         let formattedRangeDescription = range.description
//                                             .replace(/ /g, '&nbsp;')   // แปลงช่องว่างเป็น &nbsp;
//                                             .replace(/\t/g, '&emsp;')  // แปลง \t เป็น &emsp; สำหรับแท็บ
//                                             .replace(/\n/g, '<br>');   // แปลง \n เป็น <br> สำหรับขึ้นบรรทัดใหม่
                                        
//                                         return `
//                                             <div style="visibility: hidden">${formattedRangeDescription || ''}</div>
//                                             ${/\.(png|jpg|jpeg|gif)$/i.test(range.range) ? 
//                                                 `<img src="${range.range}" alt="Image" style="width: 300px;visibility: hidden" />` : 
//                                                 `<div style="margin-left: 15px;visibility: hidden">
//                                                     ${range.range ? range.range.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
//                                                 </div>`
//                                             }
//                                         `;
//                                     }).join('')}
//                                 </div>
//                             `).join('')}
//                         </div>
//                     </div>
//                 </td>
//                 <td>
//                     <button class="btn btn-danger btn-sm" onclick="removeRow(${index})">ลบ</button>
//                 </td>
//             </tr>
//         `;
//         tbody.append(row);
//     });
// }



function renderCalScopeWithParameterTable() {
    let wrapper = $('#scope_table_wrapper');
    wrapper.empty(); // ล้างข้อมูลเก่าก่อน
    lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || [];
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    let labTypes = lab_main_address.lab_types; // ดึง lab_types ออกมา

    for (let i = 1; i <= 5; i++) { // วนลูปตั้งแต่ 1 ถึง 5
        let key = `pl_2_${i}_main`; // สร้างชื่อ key เช่น pl_2_1_main, pl_2_2_main

        if (Array.isArray(labTypes[key])) { // ตรวจสอบว่าค่าเป็น array หรือไม่

            let facilityType = mainFacilityTypes.find(type => type.id === key); // ค้นหา label จาก mainFacilityTypes
            let labelText = facilityType ? facilityType.text : "ไม่ทราบประเภท"; // ตรวจสอบว่าเจอหรือไม่

            let lab_cal_scope_data_transaction = labTypes[key];
            // สร้างตัวแปรสำหรับนับจำนวน category


                    // จัดเรียงข้อมูลตาม category
            lab_cal_scope_data_transaction.sort((a, b) => {
                if (a.category < b.category) return -1;
                if (a.category > b.category) return 1;
                return 0;
            });

            let categoryCounts = {};
            lab_cal_scope_data_transaction.forEach(item => {
                if (!categoryCounts[item.category]) {
                    categoryCounts[item.category] = lab_cal_scope_data_transaction.filter(scope => scope.category === item.category).length;
                }
            });

            let renderedCategories = {}; // เก็บว่า category ไหนถูก render ไปแล้วหรือยัง
            

            let tableContent = '';
            if (lab_cal_scope_data_transaction && lab_cal_scope_data_transaction.length > 0) {
                tableContent = `
                <h5 class="text-primary">${labelText}</h5> 
                <table class="table table-bordered align-middle" id="cal_scope_table_${key}">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white">สาขาการสอบเทียบ</th>
                            <th class="text-center text-white">รายการสอบเทียบ</th>
                            <th class="text-center text-white">ค่าขีดความสามารถของ</th>
                            <th class="text-center text-white">วิธีการที่ใช้</th>
                            <th class="text-center text-white">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            }

            lab_cal_scope_data_transaction.forEach((item, index) => {
                let isFirstOccurrence = !renderedCategories[item.category];
                if (isFirstOccurrence) {
                    renderedCategories[item.category] = true;
                }

                console.log(item)
            
                let formattedDescription = item.description
                    .replace(/ /g, '&nbsp;')
                    .replace(/\t/g, '&emsp;')
                    .replace(/\n/g, '<br>');
                tableContent += `
                    <tr>
                        ${isFirstOccurrence ? `<td rowspan="${categoryCounts[item.category]}" style="vertical-align: top;"><span style="font-weight:600"> สาขา${item.category_th}</span></td>` : ''}
                        <td>
                            <div>${item.instrument_text}</div>
                            <div style="margin-left: 15px;">
                                ${formattedDescription ? `<div style="white-space: pre-wrap;">${formattedDescription}</div>` : ''}
                                <div style="${formattedDescription ? 'margin-left: 15px;' : ''}">
                                    ${item.measurements.map(measurement => `
                                        <div>${measurement.name}</div>
                                        <div style="margin-left: 15px;">
                                            ${measurement.ranges.map(range => {
                                                let formattedRangeDescription = range.description
                                                    .replace(/ /g, '&nbsp;')
                                                    .replace(/\t/g, '&emsp;')
                                                    .replace(/\n/g, '<br>');
                                                return `
                                                    <div>${formattedRangeDescription || ''}</div>
                                                    ${/\.(png|jpg|jpeg|gif)$/i.test(range.range) ? 
                                                        `<img src="${range.range}" alt="Image" style="width: 300px;" />` : 
                                                        `<div style="margin-left: 15px;">
                                                            ${range.range ? range.range.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
                                                        </div>`
                                                    }
                                                `;
                                            }).join('')}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="visibility: hidden;">${item.instrument_text}</div>
                            <div style="margin-left: 15px;">
                                ${formattedDescription ? `<div style="visibility: hidden;white-space: pre-wrap;">${formattedDescription}</div>` : ''}
                                <div style="${formattedDescription ? 'margin-left: 15px;' : ''}">
                                    ${item.measurements.map(measurement => `
                                        <div style="visibility: hidden;">${measurement.name}</div>
                                        <div style="margin-left: 15px;">
                                            ${measurement.ranges.map(range => {
                                                let formattedRangeDescription = range.description
                                                    .replace(/ /g, '&nbsp;')
                                                    .replace(/\t/g, '&emsp;')
                                                    .replace(/\n/g, '<br>');
                                                return `
                                                    <div style="visibility: hidden">${formattedRangeDescription || ''}</div>
                                                    ${/\.(png|jpg|jpeg|gif)$/i.test(range.uncertainty) ? 
                                                        `<img src="${range.uncertainty}" alt="Image" style="max-width: 160px;" />` : 
                                                        `<div style="margin-left: 15px;">
                                                            ${range.uncertainty ? range.uncertainty.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
                                                        </div>`
                                                    }
                                                `;
                                            }).join('')}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="visibility: hidden;">${item.instrument_text}</div>
                            <div style="margin-left: 15px;">
                                ${item.measurements.map(measurement => `
                                    <div>${item.standard ? item.standard.split('\n').map(line => `<div>${line}</div>`).join('') : ''}</div>
                                `).join('')}
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm" onclick="removeRow(${index}, '${key}')">ลบ</button>
                        </td>
                    </tr>
                `;
            });
            
            tableContent += `
                    </tbody>
                </table>
            `;
            // เพิ่ม HTML ของตารางลงใน wrapper (ใช้ append แทน html)
            wrapper.append(tableContent);
        }
    }

    if (Array.isArray(lab_addresses_array)) {
        for (let i = 0; i < lab_addresses_array.length; i++) {
            const branchLabType = lab_addresses_array[i].lab_types;
        
            // สร้าง header สำหรับแต่ละสาขา (แสดงครั้งเดียว)
            let header = `<h5 class="text-primary">สาขา${lab_addresses_array[i].address_district_add_modal}</h5>`;
            let tableWrapper = ""; // เก็บเนื้อหาของตารางทั้งหมดในแต่ละสาขา
            for (let j = 1; j <= 5; j++) { // วนลูปตั้งแต่ 1 ถึง 5
                let key = `pl_2_${j}_branch`; // สร้างชื่อ key เช่น pl_2_1_main, pl_2_2_main
        
                if (Array.isArray(branchLabType[key])) { // ตรวจสอบว่าค่าเป็น array หรือไม่
                    // console.log(`Key ที่เป็น array: ${key}`); // แสดง key ที่เป็น array
                    // console.log(`ค่าของ ${key}:`, branchLabType[key]); // ดึงค่าของคีย์ที่เป็น array ออกมา
        
                    let facilityType = branchFacilityTypes.find(type => type.id === key); // ค้นหา label จาก mainFacilityTypes
                    let labelText = facilityType ? facilityType.text : "ไม่ทราบประเภท"; // ตรวจสอบว่าเจอหรือไม่
        
                    let lab_cal_scope_data_transaction = branchLabType[key];
                    // สร้างตัวแปรสำหรับนับจำนวน category
    
    
                    lab_cal_scope_data_transaction.sort((a, b) => {
                        if (a.category < b.category) return -1;
                        if (a.category > b.category) return 1;
                        return 0;
                    });
    
                    let categoryCounts = {};
                    lab_cal_scope_data_transaction.forEach(item => {
                        if (!categoryCounts[item.category]) {
                            categoryCounts[item.category] = lab_cal_scope_data_transaction.filter(scope => scope.category === item.category).length;
                        }
                    });
        
                    let renderedCategories = {}; // เก็บว่า category ไหนถูก render ไปแล้วหรือยัง
                    let tableContent = '';
                    if (lab_cal_scope_data_transaction && lab_cal_scope_data_transaction.length > 0) {
                        tableContent = `
                        <h5 class="text-primary">${labelText}</h5> 
                        <table class="table table-bordered align-middle" id="cal_scope_table_${key}">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center text-white">สาขาการสอบเทียบ</th>
                                    <th class="text-center text-white">รายการสอบเทียบ</th>
                                    <th class="text-center text-white">ค่าขีดความสามารถของ</th>
                                    <th class="text-center text-white">วิธีการที่ใช้</th>
                                    <th class="text-center text-white">ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    }
        
                    lab_cal_scope_data_transaction.forEach((item, index) => {
                        let isFirstOccurrence = !renderedCategories[item.category];
                        if (isFirstOccurrence) {
                            renderedCategories[item.category] = true;
                        }
        
                        console.log(item)
                    
                        let formattedDescription = item.description
                            .replace(/ /g, '&nbsp;')
                            .replace(/\t/g, '&emsp;')
                            .replace(/\n/g, '<br>');
                        tableContent += `
                            <tr>
                                ${isFirstOccurrence ? `<td rowspan="${categoryCounts[item.category]}" style="vertical-align: top;"><span style="font-weight:600"> สาขา${item.category_th}</span></td>` : ''}
                                <td>
                                    <div>${item.instrument_text}</div>
                                    <div style="margin-left: 15px;">
                                        ${formattedDescription ? `<div style="white-space: pre-wrap;">${formattedDescription}</div>` : ''}
                                        <div style="${formattedDescription ? 'margin-left: 15px;' : ''}">
                                            ${item.measurements.map(measurement => `
                                                <div>${measurement.name}</div>
                                                <div style="margin-left: 15px;">
                                                    ${measurement.ranges.map(range => {
                                                        let formattedRangeDescription = range.description
                                                            .replace(/ /g, '&nbsp;')
                                                            .replace(/\t/g, '&emsp;')
                                                            .replace(/\n/g, '<br>');
                                                        return `
                                                            <div>${formattedRangeDescription || ''}</div>
                                                            ${/\.(png|jpg|jpeg|gif)$/i.test(range.range) ? 
                                                                `<img src="${range.range}" alt="Image" style="width: 300px;" />` : 
                                                                `<div style="margin-left: 15px;">
                                                                    ${range.range ? range.range.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
                                                                </div>`
                                                            }
                                                        `;
                                                    }).join('')}
                                                </div>
                                            `).join('')}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="visibility: hidden;">${item.instrument_text}</div>
                                    <div style="margin-left: 15px;">
                                        ${formattedDescription ? `<div style="visibility: hidden;white-space: pre-wrap;">${formattedDescription}</div>` : ''}
                                        <div style="${formattedDescription ? 'margin-left: 15px;' : ''}">
                                            ${item.measurements.map(measurement => `
                                                <div style="visibility: hidden;">${measurement.name}</div>
                                                <div style="margin-left: 15px;">
                                                    ${measurement.ranges.map(range => {
                                                        let formattedRangeDescription = range.description
                                                            .replace(/ /g, '&nbsp;')
                                                            .replace(/\t/g, '&emsp;')
                                                            .replace(/\n/g, '<br>');
                                                        return `
                                                            <div style="visibility: hidden">${formattedRangeDescription || ''}</div>
                                                            ${/\.(png|jpg|jpeg|gif)$/i.test(range.uncertainty) ? 
                                                                `<img src="${range.uncertainty}" alt="Image" style="width: 300px;" />` : 
                                                                `<div style="margin-left: 15px;">
                                                                    ${range.uncertainty ? range.uncertainty.split('\n').map(line => `<div>${line}</div>`).join('') : ''}
                                                                </div>`
                                                            }
                                                        `;
                                                    }).join('')}
                                                </div>
                                            `).join('')}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="visibility: hidden;">${item.instrument_text}</div>
                                    <div style="margin-left: 15px;">
                                        ${item.measurements.map(measurement => `
                                            <div>${item.standard ? item.standard.split('\n').map(line => `<div>${line}</div>`).join('') : ''}</div>
                                        `).join('')}
                                    </div>
                                </td>
                                <td class="text-center">
                                    
                                    <button class="btn btn-danger btn-sm" onclick="removeBranchCalRow(${index}, '${key}', ${i})">ลบ</button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    tableContent += `
                            </tbody>
                        </table>
                    `;
                    // เพิ่ม HTML ของตารางลงใน wrapper (ใช้ append แทน html)
                    wrapper.append(header + tableContent);
                }
            }
    
        }
    }
   
}


function removeRow(index, key) {
    console.log('ลบ',index, key)
    // ลบรายการออกจาก lab_cal_scope_data_transaction สำหรับ key ที่กำหนด
    lab_main_address.lab_types[key].splice(index, 1);

    sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
    lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || [];

    // เรียกฟังก์ชัน render ใหม่
    renderCalScopeWithParameterTable();
}

$(document).on('click', '#button_add_cal_scope_old', function(e) {
    e.preventDefault();

    // เรียกใช้ฟังก์ชัน
    if (checkUnselectedOptions()) {
        alert('กรุณาเลือกรายการให้ครบถ้วน');
        return
    } 
    
    if (globalTypeNumber !== undefined && globalBranchNumber !== undefined) {
        console.log('สาขาแยกขอบข่าย aaa');

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

            cal_method: ''
        };

        // ดึงข้อมูล array จาก sessionStorage
        lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

        if (lab_addresses_array[globalBranchNumber]) {
            if (!Array.isArray(lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'])) {
                lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'] = [];
            }

            lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'].push(selectedValues);
        }

        sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
        console.log(lab_addresses_array);
        renderCalScopeTable(globalBranchNumber, globalTypeNumber);

    } else if (globalTypeNumber === undefined && globalBranchNumber !== undefined ) {
        console.log('สาขาขอบข่ายร่วมกกก');



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

            cal_method: ''
        };

        lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
        
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
    }else if(globalTypeNumber === undefined && globalBranchNumber === undefined ){
        // console.log('ccc');
        console.log('สำนักงานใหญ่ขอบข่ายร่วม')
        
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

            cal_method: ''
        };

    
        // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
        
        if (lab_main_address) {
            var lab_types = lab_main_address.lab_types;
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key])) {
                    lab_types[key].push(selectedValues);
                } else if (lab_types[key] === 1) {
                    // ถ้าค่าเป็น 0 หรือ 1 เปลี่ยนให้เป็น array ก่อนแล้วค่อยเพิ่ม selectedValues
                    lab_types[key] = [selectedValues];
                }
            }
        }

        sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
        lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || [];
        console.log(lab_main_address);
        renderCalScopeTable(globalBranchNumber, globalTypeNumber);
    }else if(globalTypeNumber !== undefined && globalBranchNumber === undefined ){
        console.log('สำนักงานใหญ่ แยกขอบข่าย')
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

            cal_method: ''
        };

        // ดึงข้อมูล array จาก sessionStorage
        // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };

        if (lab_main_address) {
            if (!Array.isArray(lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'])) {
                lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'] = [];
            }

            lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'].push(selectedValues);
        }

        sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
        lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || [];
        console.log(lab_main_address);
        renderCalScopeTable(globalBranchNumber, globalTypeNumber);
    }
});


function checkUnselectedOptions() {
    var selectIds = ['#cal_main_branch', '#cal_instrumentgroup', '#cal_instrument', '#cal_parameter_one', '#cal_parameter_two'];
    
    for (var i = 0; i < selectIds.length; i++) {
        var selectId = selectIds[i];
        
        // ตรวจสอบว่า select มี option หรือไม่
        if ($(selectId + ' option').length > 0) {
            
            // ตรวจสอบว่ามี option ที่ selected หรือไม่ และถ้ามี value เท่ากับ "not_select"
            if ($(selectId + ' option:selected').val() === "not_select") {
                console.log(selectId + ' ยังไม่ได้เลือก option ที่ถูกต้อง');
                return true; // มี select ที่ไม่ได้เลือก option ที่ถูกต้อง
            }
        } else {
            console.log(selectId + ' ไม่มี option');
        }
    }
    
    return false; // ทุก select ถูกเลือก option ที่ถูกต้องแล้ว
}


$(document).on('click', '.add-lab-main-scope_old', function(e) {
    e.preventDefault();
    lab_cal_scope_data_transaction = [];
    globalTypeNumber = $(this).data('type');
    globalBranchNumber = $(this).data('branch');

    if (globalTypeNumber === "undefined" || globalTypeNumber === "") {
        globalTypeNumber = undefined;
    }
    
    if (globalBranchNumber === "undefined" || globalBranchNumber === "") {
        globalBranchNumber = undefined;
        globalBranchOffice = "สำนักงานใหญ่"
    }else{
        globalBranchOffice = "สำนักงานสาขา"
    }

    var diffScopeFound = false;
    console.log(globalTypeNumber);
    console.log(globalBranchNumber);
    console.log("สำนักงาน"+ globalBranchOffice + " ประเภทที่ " + globalTypeNumber);
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    
    if(globalTypeNumber === undefined){
        var lab_types = lab_main_address.lab_types;
        console.log(lab_types);
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
            // หา referenceItem จากคีย์แรกที่เป็น array
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key])) {
                    referenceItem = lab_types[key]; // ใช้รายการแรกเป็น reference
                    break;
                }
            }

            // ถ้ามี referenceItem แล้วเปรียบเทียบกับรายการอื่นๆ
            if (referenceItem) {
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key])) {
                        for (var index = 0; index < lab_types[key].length; index++) {
                            var item = lab_types[key][index];
                            var refItem = referenceItem[index];

                            // ตรวจสอบว่าทุกคีย์ใน item และ refItem เหมือนกันหรือไม่
                            for (var prop in refItem) {
                                if (item[prop] !== refItem[prop]) {
                                    // alert(`พบค่าที่ไม่เหมือนกันใน ${key} ที่ index ${index}, property: ${prop}`);
                                    diffScopeFound = true;
                                    break; // หยุดการทำงานของ for loop ภายในเมื่อเจอค่าที่ไม่เหมือนกัน
                                }
                            }

                            if (diffScopeFound) {
                                break; // หยุดการทำงานของ for loop หลักเมื่อเจอค่าที่ไม่เหมือนกัน
                            }
                        }
                    }

                    if (diffScopeFound) {
                        break; // หยุดการทำงานของ for loop หลักเมื่อเจอค่าที่ไม่เหมือนกัน
                    }
                }
            }
            
        }
        // console.log('diffScopeFound ' + diffScopeFound)
        
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

        // console.log('diffScopeFound ' + diffScopeFound)

    }

    if (diffScopeFound === true && globalTypeNumber === undefined ) {
        // alert('ตรวจพบ Scope ของแต่ละประเภทแตกต่างกัน โปรดเลือกประเภทหลัก ประเภทอื่น ๆ ถูกปรับ scope ร่วมกับประเภทที่เลือก');

        // ตรวจสอบว่ามีข้อมูลใน globalBranchNumber หรือไม่
        var lab_types = lab_main_address.lab_types;

        // เคลียร์ตัวเลือกทั้งหมดใน select element ก่อนด้วย jQuery
        var $selectMainType = $('#select_ref_main');
        $selectMainType.empty(); // เคลียร์ตัวเลือกทั้งหมด

        for (var key in lab_types) {
            if (Array.isArray(lab_types[key])) {
                // ตรวจสอบว่าคีย์ตรงกับ id ใน mainFacilityTypes หรือไม่
                var matchedFacility = mainFacilityTypes.find(function(facility) {
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

        $('#modal-select-ref-main').modal('show');
    }
    else
    {
        showAddCalScopeModal();
    }


    
});

$(document).on('click', '.add-lab-main-scope', function(e) {
    e.preventDefault();
    lab_cal_scope_data_transaction = [];
    globalTypeNumber = $(this).data('type');
    globalBranchNumber = $(this).data('branch');

    if (globalTypeNumber === "undefined" || globalTypeNumber === "") {
        globalTypeNumber = undefined;
    }
    
    if (globalBranchNumber === "undefined" || globalBranchNumber === "") {
        globalBranchNumber = undefined;
        globalBranchOffice = "สำนักงานใหญ่"
    }else{
        globalBranchOffice = "สำนักงานสาขา"
    }

    var diffScopeFound = false;
    console.log(globalTypeNumber);
    console.log(globalBranchNumber);
    console.log("สำนักงาน"+ globalBranchOffice + " ประเภทที่ " + globalTypeNumber);
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    
    // if(globalTypeNumber === undefined){
    //     var lab_types = lab_main_address.lab_types;
    //     console.log(lab_types);
    //     var arrayLengths = [];

    //     for (var key in lab_types) {
    //         if (Array.isArray(lab_types[key])) {
    //             // เก็บ length ของแต่ละ array ใน arrayLengths
    //             arrayLengths.push(lab_types[key].length);
    //         }
    //     }
    //     // ตรวจสอบว่า length ของทุก array เท่ากันหรือไม่
    //     var allEqualLengths = arrayLengths.every(function(length, _, arr) {
    //         return length === arr[0];
    //     });
        
    //     if (!allEqualLengths) {
    //         // alert('จำนวนรายการใน array ของ lab_types ไม่เท่ากัน');
    //         diffScopeFound = true;
    //     } 
    //     else 
    //     {
    //         console.log('จำนวนรายการใน array ของ lab_types เท่ากันทั้งหมด');
    //         // เริ่มตรวจสอบค่าภายใน array ของแต่ละ lab_types[key]
    //         var referenceItem;
    //         // หา referenceItem จากคีย์แรกที่เป็น array
    //         for (var key in lab_types) {
    //             if (Array.isArray(lab_types[key])) {
    //                 referenceItem = lab_types[key]; // ใช้รายการแรกเป็น reference
    //                 break;
    //             }
    //         }

    //         // ถ้ามี referenceItem แล้วเปรียบเทียบกับรายการอื่นๆ
    //         if (referenceItem) {
    //             for (var key in lab_types) {
    //                 if (Array.isArray(lab_types[key])) {
    //                     for (var index = 0; index < lab_types[key].length; index++) {
    //                         var item = lab_types[key][index];
    //                         var refItem = referenceItem[index];

    //                         // ตรวจสอบว่าทุกคีย์ใน item และ refItem เหมือนกันหรือไม่
    //                         for (var prop in refItem) {
    //                             if (item[prop] !== refItem[prop]) {
    //                                 // alert(`พบค่าที่ไม่เหมือนกันใน ${key} ที่ index ${index}, property: ${prop}`);
    //                                 diffScopeFound = true;
    //                                 break; // หยุดการทำงานของ for loop ภายในเมื่อเจอค่าที่ไม่เหมือนกัน
    //                             }
    //                         }

    //                         if (diffScopeFound) {
    //                             break; // หยุดการทำงานของ for loop หลักเมื่อเจอค่าที่ไม่เหมือนกัน
    //                         }
    //                     }
    //                 }

    //                 if (diffScopeFound) {
    //                     break; // หยุดการทำงานของ for loop หลักเมื่อเจอค่าที่ไม่เหมือนกัน
    //                 }
    //             }
    //         }
            
    //     }
    //     // console.log('diffScopeFound ' + diffScopeFound)
        
    //     var foundValue = false; // ตัวแปรเพื่อบันทึกว่าพบค่า 1 หรือไม่
    //     var foundArray = false; // ตัวแปรเพื่อบันทึกว่าพบ array หรือไม่

    //     for (var key in lab_types) {
    //         if (lab_types[key] == 1) {
    //             foundValue = true; // พบค่า 1
    //         }

    //         if (Array.isArray(lab_types[key])) {
    //             referenceItem = lab_types[key]; // ใช้ array นี้เป็น reference
    //             foundArray = true; // พบ array
    //         }

    //         // ถ้าพบทั้งค่า 1 และ array ให้ break ออกจาก loop
    //         if (foundValue && foundArray) {
    //             diffScopeFound = true;
    //             // alert('จำนวนรายการใน array ของ lab_types ปนกับค่า 1');
    //             break;
    //         }
    //     }

    //     // console.log('diffScopeFound ' + diffScopeFound)

    // }

    // if (diffScopeFound === true && globalTypeNumber === undefined ) {
    //     // alert('ตรวจพบ Scope ของแต่ละประเภทแตกต่างกัน โปรดเลือกประเภทหลัก ประเภทอื่น ๆ ถูกปรับ scope ร่วมกับประเภทที่เลือก');

    //     // ตรวจสอบว่ามีข้อมูลใน globalBranchNumber หรือไม่
    //     var lab_types = lab_main_address.lab_types;

    //     // เคลียร์ตัวเลือกทั้งหมดใน select element ก่อนด้วย jQuery
    //     var $selectMainType = $('#select_ref_main');
    //     $selectMainType.empty(); // เคลียร์ตัวเลือกทั้งหมด

    //     for (var key in lab_types) {
    //         if (Array.isArray(lab_types[key])) {
    //             // ตรวจสอบว่าคีย์ตรงกับ id ใน mainFacilityTypes หรือไม่
    //             var matchedFacility = mainFacilityTypes.find(function(facility) {
    //                 return facility.id === key;
    //             });

    //             // ถ้าพบคีย์ตรงกัน ให้นำ text มาใช้
    //             if (matchedFacility) {
    //                 $selectMainType.append($('<option>', {
    //                     value: key,
    //                     text: matchedFacility.text
    //                 }));
    //             }
    //         }
    //     }

    //     $('#modal-select-ref-main').modal('show');
    // }
    // else
    // {
    //     showAddCalScopeModal();
    // }

    showAddCalScopeModal();

    
});


// ฟังก์ชันค้นหา scopes จาก lab_types
function findScopes(lab_types, typeKey) {
    if (typeKey === undefined) {
        // ค้นหาคีย์แรกที่มีค่าไม่เท่ากับ 0 และเป็น array
        for (var key in lab_types) {
            if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                return lab_types[key];
            }
        }
    } else if (Array.isArray(lab_types[typeKey])) {
        // กรณี typeKey ไม่ใช่ undefined และเป็น array ที่ต้องการ
        return lab_types[typeKey];
    }
    return null;
}

function renderCalScopeTable(branchNumber, typeNumber) {
    // lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    var scopes = null;

    if(branchNumber !== undefined)
    {
        //สาขาจะมี branch
        if (typeNumber === undefined) {
            
            var lab_types = lab_addresses_array[branchNumber].lab_types;
            console.log('ค้นหา scope สาขา ขอบข่ายร่วม')
            console.log(lab_types);
            // ค้นหาคีย์แรกที่มีค่าไม่เท่ากับ 0 และเป็น array
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                    scopes = lab_types[key];
                    break;
                }
            }
        } else if (lab_addresses_array[branchNumber] && Array.isArray(lab_addresses_array[branchNumber].lab_types['pl_2_' + typeNumber + '_branch'])) {
            console.log('ค้นหา scope สาขา แยกประเภท')
            // กรณี typeNumber ไม่ใช่ null และเป็น array ที่ต้องการ
            scopes = lab_addresses_array[branchNumber].lab_types['pl_2_' + typeNumber + '_branch'];
        }    
    }else {
        //สำนักงานใหญ่ไม่มี branch
        if (typeNumber === undefined) {
            var lab_types = lab_main_address.lab_types;
            
            // ค้นหาคีย์แรกที่มีค่าไม่เท่ากับ 0 และเป็น array
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                    scopes = lab_types[key];
                    break;
                }
            }
        } else if (lab_main_address && Array.isArray(lab_main_address.lab_types['pl_2_' + typeNumber + '_main'])) {
            // กรณี typeNumber ไม่ใช่ null และเป็น array ที่ต้องการ
            scopes = lab_main_address.lab_types['pl_2_' + typeNumber + '_main'];
        }  
    }

    $('#lab_cal_scope_body').empty();

    if (scopes) {
   
        var rows = [];

        scopes.forEach(function(scope, index) {
            var parameterOneButton = '';
            var parameterTwoButton = '';
            var parameterOneValue = '';
            var parameterTwoValue = '';
            var calMethodValue = '';
            
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

            if (scope.cal_method !== '') {
                calMethodValue = `${scope.cal_method}`;
            }

            var calMethodButton = `<button type="button" class="btn btn-info btn-xs btn-add-items-cal-method" data-index="${index}">
                                        <i class="fa fa-plus"></i>
                                    </button>`;
            var newRow = `<tr>
                <td>${scope.cal_main_branch_text}</td>
                <td>${scope.cal_instrumentgroup_text}</td>
                <td>${scope.cal_instrument_text}</td>
                <td>${scope.cal_parameter_one_text} ${parameterOneButton} ${parameterOneValue}</td>
                <td>${scope.cal_parameter_two_text} ${parameterTwoButton} ${parameterTwoValue}</td>
                <td>${calMethodButton} ${calMethodValue}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-xs btn-delete-scope-row" data-index="${index}">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>`;

            // เก็บ newRow ไว้ใน array
            rows.push({
                branchText: scope.cal_main_branch_text,
                rowHtml: newRow
            });
        });

        // จัดเรียง array ตาม branchText
        rows.sort(function(a, b) {
            return a.branchText.localeCompare(b.branchText);
        });

        // render ตารางที่จัดเรียงแล้วไปยัง #lab_cal_scope_body
        rows.forEach(function(item) {
            $('#lab_cal_scope_body').append(item.rowHtml);
        });

    }
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };

    // var tableContainer = $('#myTable_lab_cal_scope'); // ใช้ ID ของคอนเทนเนอร์ที่คุณใช้แสดงตาราง
    // tableContainer.scrollTop(tableContainer[0].scrollHeight);
}

let cal_parameter_cmc_ranges = [];
// เมื่อคลิกปุ่มเพิ่ม
// $('#btn_add_cal_param_cmc').on('click', function () {
//     // ดึงค่าจากฟอร์ม
//     let description = $('#description').val();
//     let range = $('#cal_param_range_textarea').val();
//     let uncertainty = $('#cal_cmc_uncertainty_textarea').val();

//     // ตรวจสอบค่าก่อนเพิ่ม
//     if (!description || !range || !uncertainty) {
//         alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');
//         return;
//     }

//     // เพิ่มข้อมูลลงใน array
//     cal_parameter_cmc_ranges.push({
//         description: description,
//         range: range,
//         uncertainty: uncertainty,
//     });

//     // แสดงข้อมูลในตาราง
//     renderParamCMCTable();

//     // ล้างฟิลด์ในฟอร์ม
//     $('#description').val('');
//     $('#cal_param_range_textarea').val('');
//     $('#cal_cmc_uncertainty_textarea').val('');
//     $('#modal-add-cal-param-cmc').modal('hide');
// });

// $('#btn_add_cal_param_cmc').on('click', function () {
//     // ดึงค่าจากฟอร์ม
//     let description = $('#description').val();

//     // ตรวจสอบว่าระหว่าง text กับ file ต้องใช้ค่าใด
//     let range, uncertainty;

//     if ($('#cal_param_use_text').is(':checked')) {
//         // ถ้าเลือกข้อความ
//         range = $('#cal_param_range_textarea').val();
//     } else if ($('#cal_param_use_picture').is(':checked')) {
//         // ถ้าเลือกไฟล์
//         let fileInput = $('#cal_param_file')[0];
//         if (fileInput.files.length > 0) {
//             range = fileInput.files[0]; // เก็บไฟล์
//         } else {
//             alert('กรุณาอัปโหลดไฟล์สำหรับช่วงพารามิเตอร์');
//             return;
//         }
//     }

//     if ($('#cal_use_text').is(':checked')) {
//         // ถ้าเลือกข้อความ
//         uncertainty = $('#cal_cmc_uncertainty_textarea').val();
//     } else if ($('#cal_use_picture').is(':checked')) {
//         // ถ้าเลือกไฟล์
//         let fileInput = $('#cal_cmc_file')[0];
//         if (fileInput.files.length > 0) {
//             uncertainty = fileInput.files[0]; // เก็บไฟล์
//         } else {
//             alert('กรุณาอัปโหลดไฟล์สำหรับ CMC');
//             return;
//         }
//     }

//     // ตรวจสอบค่าก่อนเพิ่ม
//     if (!description || !range || !uncertainty) {
//         alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');
//         return;
//     }

//     // เพิ่มข้อมูลลงใน array
//     cal_parameter_cmc_ranges.push({
//         description: description,
//         range: range,
//         uncertainty: uncertainty,
//     });

//     // แสดงข้อมูลในตาราง
//     renderParamCMCTable();

//     // ล้างฟิลด์ในฟอร์ม
//     $('#description').val('');
//     $('#cal_param_range_textarea').val('');
//     $('#cal_cmc_uncertainty_textarea').val('');
//     $('#cal_param_file').val('');
//     $('#cal_cmc_file').val('');
//     $('#modal-add-cal-param-cmc').modal('hide');
// });


// function renderParamCMCTable() {
//     let tbody = $('#cal_parameter_cmc_body');
//     tbody.empty(); // ลบข้อมูลเก่าทั้งหมดก่อนแสดงใหม่

//     cal_parameter_cmc_ranges.forEach((item, index) => {
//         // ตรวจสอบว่าข้อมูล range เป็นไฟล์หรือไม่
//         let rangeDisplay = (typeof item.range === 'object' && item.range.name) 
//             ? item.range.name // แสดงชื่อไฟล์
//             : item.range;     // แสดงข้อความ

//         // ตรวจสอบว่าข้อมูล uncertainty เป็นไฟล์หรือไม่
//         let uncertaintyDisplay = (typeof item.uncertainty === 'object' && item.uncertainty.name) 
//             ? item.uncertainty.name // แสดงชื่อไฟล์
//             : item.uncertainty;     // แสดงข้อความ

//         // สร้างแถวของตาราง
//         let row = `
//             <tr>
//                 <td>${item.description}</td>
//                 <td>${rangeDisplay}</td>
//                 <td>${uncertaintyDisplay}</td>
//                 <td class="text-center">
//                     <button class="btn btn-danger btn-sm btn-param-cmc-delete" data-index="${index}">
//                         ลบ
//                     </button>
//                 </td>
//             </tr>
//         `;
//         tbody.append(row);
//     });
// }


// ลบข้อมูลใน array และตาราง
// $('#cal_parameter_cmc_body').on('click', '.btn-param-cmc-delete', function () {
//     let index = $(this).data('index');
//     cal_parameter_cmc_ranges.splice(index, 1); // ลบข้อมูลใน array
//     renderParamCMCTable(); // อัปเดตตารางใหม่
// });

// สร้างโครงสร้าง measurements
// let measurements = [{
//     name: $('#cal_parameters').val(), // ค่า ID "cal_parameters"
//     type: $('input[name="cal_parameters_type"]:checked').val(), // เลือกค่าจาก radio
//     ranges: [] // อาร์เรย์สำหรับเก็บ ranges
// }];

// เพิ่มข้อมูลลงใน ranges
// let rangeLines = "";
let uncertaintyLines = "";
$('#btn_add_cal_param_cmc').on('click', function () {
    // ดึงค่าจากฟอร์ม
    let description = document.getElementById('description').value;

    // แยกบรรทัดจาก textarea
    
    

    // const selectedParamValue = $('input[name="cal_param_option"]:checked').val();
        
    // if (selectedParamValue === 'text') {
        // console.log("parameter ถูกเลือก: ข้อความ");
    let rangeLines = $('#cal_param_range_textarea').val().split('\n').filter(line => line.trim() !== '');
        // ดำเนินการเมื่อเลือก 'ข้อความ'
    // } else if (selectedParamValue === 'picture') {
    //     console.log("parameter ถูกเลือก: รูปภาพ");
    //     // ดำเนินการเมื่อเลือก 'รูปภาพ'
    // }
    let path = '';
    const selectedCmcValue = $('input[name="cal_cmc_option"]:checked').val();
        
    if (selectedCmcValue === 'text') {
        console.log("cmc ถูกเลือก: ข้อความ");
        uncertaintyLines = $('#cal_cmc_uncertainty_textarea').val().split('\n').filter(line => line.trim() !== '');
        // ดำเนินการเมื่อเลือก 'ข้อความ'
    } else if (selectedCmcValue === 'picture') {
        console.log("cmc ถูกเลือก: รูปภาพ");
        path = $('#cal_cmc_file').val(); // ดึง path ของไฟล์
        // console.log(path)
        // ดำเนินการเมื่อเลือก 'รูปภาพ'
    }

    createCalMeasurementData(description,rangeLines,uncertaintyLines,path)

    // แสดงข้อมูลในตาราง
    renderParamCMCTable();

    // ล้างฟิลด์ในฟอร์ม
    $('#description').val('');
    $('#cal_param_range_textarea').val('');
    $('#cal_cmc_uncertainty_textarea').val('');
    $('#cal_param_file').val('');
    $('#cal_cmc_file').val('');
    $('#modal-add-cal-param-cmc').modal('hide');
});

function createCalMeasurementData(description,rangeLines,uncertaintyLines,path)
{
    // หาจำนวนบรรทัดที่มากกว่า
    let maxLines = Math.max(rangeLines.length, uncertaintyLines.length);

       // ตรวจสอบว่าข้อมูลเป็นรูปภาพหรือไม่
    if (path !== '') {
        for (let i = 0; i < rangeLines.length; i++) {
            measurements[0].ranges.push({
                description: description,
                range: rangeLines[i] || '', // หากไม่มีบรรทัด ใช้ค่าว่าง
                uncertainty: (i === 0) ? uncertaintyLines : '', // ใช้ uncertaintyLines ในรอบแรก (i = 0), รอบอื่น ๆ ใช้ ""
            });
        }
    } else {
        // กรณีเป็นข้อความ
        for (let i = 0; i < maxLines; i++) {
            measurements[0].ranges.push({
                description: description,
                range: rangeLines[i] || '', // หากไม่มีบรรทัด ใช้ค่าว่าง
                uncertainty: uncertaintyLines[i] || '', // หากไม่มีบรรทัด ใช้ค่าว่าง
            });
        }
    }
}

function renderParamCMCTable() {
    let tbody = $('#cal_parameter_cmc_body');
    tbody.empty(); // ลบข้อมูลเก่าทั้งหมดก่อนแสดงใหม่

    console.log(measurements);
    measurements[0].ranges.forEach((item, index) => {
        // จัดรูปแบบ item.description ให้เหมาะสม
        let formattedDescription = item.description
            .replace(/ /g, '&nbsp;')   // แปลงช่องว่างเป็น &nbsp;
            .replace(/\t/g, '&emsp;')  // แปลง \t เป็น &emsp; สำหรับแท็บ
            .replace(/\n/g, '<br>');   // แปลง \n เป็น <br> สำหรับขึ้นบรรทัดใหม่

        // ตรวจสอบและแสดงข้อความหรือชื่อไฟล์
        let rangeDisplay = (typeof item.range === 'object' && item.range.name) 
            ? item.range.name 
            : item.range;

            let uncertaintyDisplay = (typeof item.uncertainty === 'object' && item.uncertainty.name) 
            ? item.uncertainty.name 
            : item.uncertainty;
        
        // ตรวจสอบว่า uncertaintyDisplay มี .png หรือไม่
        if (uncertaintyDisplay.includes('.png')) {
            uncertaintyDisplay = `<img src="${uncertaintyDisplay}" alt="uncertainty image" style="max-width: 160px;">`;
        }
        
        // สร้างแถวของตาราง
        let row = `
            <tr>
                <td style="white-space: pre-wrap;">${formattedDescription}</td>
                <td>${rangeDisplay}</td>
                <td>${uncertaintyDisplay}</td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm btn-param-cmc-delete" data-index="${index}">
                        ลบ
                    </button>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

$(document).on('click', '.btn-param-cmc-delete', function () {
    let index = $(this).data('index');
    measurements[0].ranges.splice(index, 1); // ลบข้อมูลที่ตำแหน่ง index
    renderParamCMCTable(); // อัปเดตตาราง
});


$(document).on('click', '.btn-delete-scope-row', function(e) {
    e.preventDefault();
    // หาค่า index ของแถวที่ต้องการลบ
    var rowIndex = $(this).closest('tr').index();

    // ดึงข้อมูล array จาก sessionStorage
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    // console.log(globalBranchNumber)
    // console.log(globalTypeNumber)
    if(globalBranchNumber !== undefined){
        console.log('สาขา')
        if (globalTypeNumber !== undefined) {
            console.log('ลบขอบข่ายสาขา แยกประเภท')
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
            console.log('ลบขอบข่ายสาขา ขอบข่ายร่วม')
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
    }else{
        console.log('สำนักงานใหญ่')
        if (globalTypeNumber !== undefined) {
            console.log('สำนักงานใหญ่ แยกประเภท')
            // ตรวจสอบว่า lab_addresses_array และ scopes มีข้อมูลอยู่หรือไม่
            if (lab_main_address && Array.isArray(lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'])) {
                var scopes = lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'];
    
                // ลบรายการที่เลือกจาก array
                scopes.splice(rowIndex, 1);
                
                // บันทึก array กลับไปที่ session storage
                sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
                
                // เรียกใช้ฟังก์ชันเพื่ออัปเดตตาราง
                renderCalScopeTable(globalBranchNumber, globalTypeNumber);
            }
        } else {
            // กรณีที่ globalTypeNumber เป็น undefined
            if (lab_main_address) {
                var lab_types = lab_main_address.lab_types;
                
                // ลบรายการจากทุก lab_types ที่ไม่เท่ากับ 0 และเป็น array
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key])) {
                        lab_types[key].splice(rowIndex, 1);
                    }
                }
    
                // บันทึก array กลับไปที่ session storage
                sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
                renderCalScopeTable(globalBranchNumber, globalTypeNumber);
    
            }
        }
    }

    
});


$(document).on('click', '.btn-add-items-parameter-one', function(e) {
    e.preventDefault();
    // เก็บค่า data-index จากปุ่มที่ถูกกด
    selectedScopeIndex = $(this).data('index');
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    var parameterOneValue = '';

    if(globalBranchNumber !== undefined)
    {
        console.log("--> " + globalBranchNumber);
        console.log("--> " + globalTypeNumber);
        // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber ไม่เท่ากับ undefined
        if (globalTypeNumber !== undefined) {
            console.log('สาขา แยกประเภท')
            // ดึงค่า scopes จาก lab_addresses_array ตาม globalBranchNumber และ globalTypeNumber
            var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];
    
            // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_parameter_one_value
            if (scopes && scopes[selectedScopeIndex]) {
                parameterOneValue = scopes[selectedScopeIndex].cal_parameter_one_value || '';
            }
        } 
        else 
        {
            console.log('สาขา ร่วมขอบข่าย')
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
    }
    else
    {
        // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber ไม่เท่ากับ undefined
        if (globalTypeNumber !== undefined) {
            console.log('สำนักงานใหญ่ แยกประเภท')
            // ดึงค่า scopes จาก lab_addresses_array ตาม globalBranchNumber และ globalTypeNumber
            var scopes = lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'];
    
            // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_parameter_one_value
            if (scopes && scopes[selectedScopeIndex]) {
                parameterOneValue = scopes[selectedScopeIndex].cal_parameter_one_value || '';
            }
        } else {
            // ค้นหา lab_types แรกที่ไม่เท่ากับ 0 และเป็น array
            var lab_types = lab_main_address.lab_types;
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
    }
   

    // อัปเดตค่าใน Summernote editor
    $('#parameter_one_textarea').summernote('code', parameterOneValue);


    
    // แสดง modal
    $('#modal-add-parameter-one').modal('show');

});



$('#cal_cmc_file').change(function () {
    const fileInput = document.getElementById('cal_cmc_file');
    const file = fileInput.files[0];
    const _token = $('input[name="_token"]').val();

    if (file) {
        // ตรวจสอบว่าไฟล์เป็นรูปภาพหรือไม่
        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!validImageTypes.includes(file.type)) {
            alert('กรุณาเลือกไฟล์รูปภาพที่เป็น JPEG, PNG หรือ GIF เท่านั้น');
            return;
        }

        // ตรวจสอบขนาดของรูปภาพ
        const img = new Image();
        img.onload = function () {
            if (this.width === 750 && this.height === 200) {
                // สร้าง FormData สำหรับส่งข้อมูลไฟล์
                const formData = new FormData();
                formData.append('file', file); // เพิ่มไฟล์ลงใน FormData
                formData.append('_token', _token); // เพิ่ม CSRF Token

                // ส่งข้อมูลด้วย AJAX
                $.ajax({
                    url: '/certify/applicant/upload-cal-lab-cmc', // URL ของ Route
                    type: 'POST',
                    data: formData,
                    contentType: false, // ปิดการตั้งค่า default content type
                    processData: false, // ไม่ประมวลผลข้อมูลในรูปแบบ string
                    success: function (response) {
                        uncertaintyLines = response.file_url;
                        console.log('อัปโหลดสำเร็จ', response);
                        // alert('ไฟล์ถูกอัปโหลดสำเร็จ');
                    },
                    error: function (xhr, status, error) {
                        console.error('เกิดข้อผิดพลาดในการอัปโหลดไฟล์', error);
                        alert('การอัปโหลดไฟล์ล้มเหลว');
                    }
                });
            } else {
                alert('รูปภาพต้องมีขนาด 750x200 พิกเซลเท่านั้น');
                fileInput.value = ''; // ลบไฟล์ออก
            }
        };

        img.onerror = function () {
            alert('ไม่สามารถอ่านไฟล์รูปภาพได้ กรุณาเลือกไฟล์ใหม่');
            fileInput.value = ''; // ลบไฟล์ออก
        };

        // อ่าน URL ของไฟล์รูปภาพ
        img.src = URL.createObjectURL(file);
    } else {
        alert('กรุณาเลือกไฟล์');
    }
});


$(document).on('click', '.btn-add-items-parameter-two', function(e) {
    e.preventDefault();
    // เก็บค่า data-index จากปุ่มที่ถูกกด
    selectedScopeIndex = $(this).data('index');
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    var parameterTwoValue = '';

    if(globalBranchNumber !== undefined)
    {

        // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber ไม่เท่ากับ undefined
        if (globalTypeNumber !== undefined) {
            console.log('สาขา แยกประเภท')
            // ดึงค่า scopes จาก lab_addresses_array ตาม globalBranchNumber และ globalTypeNumber
            var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];
    
            // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_parameter_two_value
            if (scopes && scopes[selectedScopeIndex]) {
                parameterTwoValue = scopes[selectedScopeIndex].cal_parameter_two_value || '';
            }
        } 
        else 
        {
            console.log('สาขา ร่วมขอบข่าย')
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
    }
    else
    {
        // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber ไม่เท่ากับ undefined
        if (globalTypeNumber !== undefined) {
            console.log('สำนักงานใหญ่ แยกประเภท')
            // ดึงค่า scopes จาก lab_addresses_array ตาม globalBranchNumber และ globalTypeNumber
            var scopes = lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'];
    
            // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_parameter_two_value
            if (scopes && scopes[selectedScopeIndex]) {
                parameterTwoValue = scopes[selectedScopeIndex].cal_parameter_two_value || '';
            }
        } else {
            // ค้นหา lab_types แรกที่ไม่เท่ากับ 0 และเป็น array
            var lab_types = lab_main_address.lab_types;
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

    }
   

    // อัปเดตค่าใน Summernote editor
    $('#parameter_two_textarea').summernote('code', parameterTwoValue);

    // แสดง modal
    $('#modal-add-parameter-two').modal('show');
});



$(document).on('click', '.btn-add-items-cal-method', function(e) {
    e.preventDefault();
    // เก็บค่า data-index จากปุ่มที่ถูกกด
    selectedScopeIndex = $(this).data('index');
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    var calMethodValue = '';

    if(globalBranchNumber !== undefined)
    {

        // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber ไม่เท่ากับ undefined
        if (globalTypeNumber !== undefined) {
            console.log('สาขา แยกประเภท')
            // ดึงค่า scopes จาก lab_addresses_array ตาม globalBranchNumber และ globalTypeNumber
            var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];
    
            // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_method
            if (scopes && scopes[selectedScopeIndex]) {
                calMethodValue = scopes[selectedScopeIndex].cal_method || '';
            }
        } 
        else 
        {
            console.log('สาขา ร่วมขอบข่าย')
            // ค้นหา lab_types แรกที่ไม่เท่ากับ 0 และเป็น array
            var lab_types = lab_addresses_array[globalBranchNumber].lab_types;
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                    var scopes = lab_types[key];
    
                    // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_method
                    if (scopes && scopes[selectedScopeIndex]) {
                        calMethodValue = scopes[selectedScopeIndex].cal_method || '';
                        break;
                    }
                }
            }
        }
    }
    else
    {
        // ตรวจสอบว่า globalBranchNumber และ globalTypeNumber ไม่เท่ากับ undefined
        if (globalTypeNumber !== undefined) {
            console.log('สำนักงานใหญ่ แยกประเภท')
            // ดึงค่า scopes จาก lab_addresses_array ตาม globalBranchNumber และ globalTypeNumber
            var scopes = lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'];
    
            // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_method
            if (scopes && scopes[selectedScopeIndex]) {
                calMethodValue = scopes[selectedScopeIndex].cal_method || '';
            }
        } else {
            // ค้นหา lab_types แรกที่ไม่เท่ากับ 0 และเป็น array
            var lab_types = lab_main_address.lab_types;
            for (var key in lab_types) {
                if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                    var scopes = lab_types[key];
    
                    // ตรวจสอบว่ามี scope ที่ selectedScopeIndex หรือไม่ และดึงค่า cal_method
                    if (scopes && scopes[selectedScopeIndex]) {
                        calMethodValue = scopes[selectedScopeIndex].cal_method || '';
                        break;
                    }
                }
            }
        }
    }
   
    // อัปเดตค่าใน Summernote editor
    $('#cal_method_textarea').summernote('code', calMethodValue);

    $('#modal-add-cal-method').modal('show');
});


$(document).on('click', '#button_add_parameter_one', function(e) {
    e.preventDefault();
    var parameterOneText = $('#parameter_one_textarea').val().trim();
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
 
    // ตรวจสอบว่ามีค่าใน parameterOneText หรือไม่
    if (parameterOneText !== ''  &&  selectedScopeIndex !== '') {

        if(globalBranchNumber !== undefined)
        {
            var lab_types = lab_addresses_array[globalBranchNumber].lab_types;
            if (globalTypeNumber !== undefined) {
                 // ค้นหาและอัปเดตเฉพาะรายการใน lab_types ที่เป็น array และไม่เท่ากับ 0
                 console.log('แยกประเภท===');
                 var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];
                 var scope = scopes[selectedScopeIndex];
                 if (scope && scope.cal_parameter_one_value !== undefined) {
                     scope.cal_parameter_one_value = parameterOneText; // อัปเดตค่าของ cal_parameter_one_value
                 }
            } else {
                console.log('ขอบข่ายร่วม');
                for (var key in lab_types) {
                    
                    if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                        console.log('==========');
                        console.log(key);
                        console.log(lab_types[key]);
                        console.log(selectedScopeIndex);
                        var scope = lab_types[key][selectedScopeIndex];
                        console.log(scope);
                        console.log('==========');
                        if (scope && scope.cal_parameter_one_value !== undefined) {
                            scope.cal_parameter_one_value = parameterOneText; // อัปเดตค่าของ cal_parameter_one_value
                        }
                    }
                }  
            }
            // บันทึกกลับไปใน sessionStorage
            sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
        }
        else
        {
            var lab_types = lab_main_address.lab_types;
            if (globalTypeNumber !== undefined) {              
                var scopes = lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'];
                var scope = scopes[selectedScopeIndex];
                if (scope && scope.cal_parameter_one_value !== undefined) {
                    scope.cal_parameter_one_value = parameterOneText; // อัปเดตค่าของ cal_parameter_one_value
                }
            } else {
                // ค้นหาและอัปเดตเฉพาะรายการใน lab_types ที่เป็น array และไม่เท่ากับ 0
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                        console.log(key);
                        console.log(lab_types[key]);
                        console.log(selectedScopeIndex);
                        var scope = lab_types[key][selectedScopeIndex];
                        if (scope && scope.cal_parameter_one_value !== undefined) {
                            scope.cal_parameter_one_value = parameterOneText; // อัปเดตค่าของ cal_parameter_one_value
                        }
                    }
                }
            }
            // บันทึกกลับไปใน sessionStorage
            sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
        }
        // ปิด modal
        $('#modal-add-parameter-one').modal('hide');
        // อัปเดตตาราง
        renderCalScopeTable(globalBranchNumber, globalTypeNumber);  
    }
});

$(document).on('click', '#button_add_parameter_two', function(e) {
    e.preventDefault();
    var parameterTwoText = $('#parameter_two_textarea').val().trim();
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    // console.log(selectedScopeIndex);
    // ตรวจสอบว่ามีค่าใน parameterTwoText หรือไม่
    if (parameterTwoText !== ''  &&  selectedScopeIndex !== '') {
        if(globalBranchNumber !== undefined)
        {
            var lab_types = lab_addresses_array[globalBranchNumber].lab_types;
            // ตรวจสอบว่า globalTypeNumber เท่ากับ undefined หรือไม่
            if (globalTypeNumber !== undefined) {
                var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];
                var scope = scopes[selectedScopeIndex];
                if (scope && scope.cal_parameter_two_value !== undefined) {
                    scope.cal_parameter_two_value = parameterTwoText; // อัปเดตค่าของ cal_parameter_two_value
                }
            } else {
                // ค้นหาและอัปเดตเฉพาะรายการใน lab_types ที่เป็น array และไม่เท่ากับ 0
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                        var scope = lab_types[key][selectedScopeIndex];
                        if (scope && scope.cal_parameter_two_value !== undefined) {
                            scope.cal_parameter_two_value = parameterTwoText; // อัปเดตค่าของ cal_parameter_two_value
                        }
                    }
                }
            }
            // บันทึกกลับไปใน sessionStorage
            sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
        }
        else
        {
            var lab_types = lab_main_address.lab_types;
            if (globalTypeNumber !== undefined) {              
                var scopes = lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'];
                var scope = scopes[selectedScopeIndex];
                if (scope && scope.cal_parameter_two_value !== undefined) {
                    scope.cal_parameter_two_value = parameterTwoText; // อัปเดตค่าของ cal_parameter_two_value
                }
            } else {
                // ค้นหาและอัปเดตเฉพาะรายการใน lab_types ที่เป็น array และไม่เท่ากับ 0
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                        var scope = lab_types[key][selectedScopeIndex];
                        if (scope && scope.cal_parameter_two_value !== undefined) {
                            scope.cal_parameter_two_value = parameterTwoText; // อัปเดตค่าของ cal_parameter_two_value
                        }
                    }
                }
            }
            // บันทึกกลับไปใน sessionStorage
            sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
        }
        // ปิด modal
        $('#modal-add-parameter-two').modal('hide');

        // อัปเดตตาราง
        renderCalScopeTable(globalBranchNumber, globalTypeNumber);  
    }
});

$(document).on('click', '#button_add_cal_method', function(e) {
    e.preventDefault();
    var calMethodText = $('#cal_method_textarea').val().trim();
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];
    // console.log(selectedScopeIndex);
    // ตรวจสอบว่ามีค่าใน calMethodText หรือไม่
    if (calMethodText !== ''  &&  selectedScopeIndex !== '') {
        if(globalBranchNumber !== undefined)
        {
            var lab_types = lab_addresses_array[globalBranchNumber].lab_types;
            // ตรวจสอบว่า globalTypeNumber เท่ากับ undefined หรือไม่
            if (globalTypeNumber !== undefined) {
                var scopes = lab_addresses_array[globalBranchNumber].lab_types['pl_2_' + globalTypeNumber + '_branch'];
                var scope = scopes[selectedScopeIndex];
                if (scope && scope.cal_method !== undefined) {
                    scope.cal_method = calMethodText; // อัปเดตค่าของ cal_method
                }
            } else {
                // ค้นหาและอัปเดตเฉพาะรายการใน lab_types ที่เป็น array และไม่เท่ากับ 0
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                        var scope = lab_types[key][selectedScopeIndex];
                        if (scope && scope.cal_method !== undefined) {
                            scope.cal_method = calMethodText; // อัปเดตค่าของ cal_method
                        }
                    }
                }
            }
            // บันทึกกลับไปใน sessionStorage
            sessionStorage.setItem('lab_addresses_array', JSON.stringify(lab_addresses_array));
        }
        else
        {
            var lab_types = lab_main_address.lab_types;
            if (globalTypeNumber !== undefined) {              
                var scopes = lab_main_address.lab_types['pl_2_' + globalTypeNumber + '_main'];
                var scope = scopes[selectedScopeIndex];
                if (scope && scope.cal_method !== undefined) {
                    scope.cal_method = calMethodText; // อัปเดตค่าของ cal_method
                }
            } else {
                // ค้นหาและอัปเดตเฉพาะรายการใน lab_types ที่เป็น array และไม่เท่ากับ 0
                for (var key in lab_types) {
                    if (Array.isArray(lab_types[key]) && lab_types[key].length > 0) {
                        var scope = lab_types[key][selectedScopeIndex];
                        if (scope && scope.cal_method !== undefined) {
                            scope.cal_method = calMethodText; // อัปเดตค่าของ cal_method
                        }
                    }
                }
            }
            // บันทึกกลับไปใน sessionStorage
            sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
        }
        // ปิด modal
        $('#modal-add-cal-method').modal('hide');

        // อัปเดตตาราง
        renderCalScopeTable(globalBranchNumber, globalTypeNumber);  
    }
});

// ใช้ event delegation สำหรับ checkbox
$(document).on('change', '.lab-scope-checkbox', function() {
    var isChecked = $(this).is(':checked');
    var typesContainer = $(this).closest('tr').find('.types-container');
    var branch_id = $(this).data('branch');

    lab_addresses_array = JSON.parse(sessionStorage.getItem('lab_addresses_array')) || [];

    if (isChecked) {
        // ซ่อนปุ่มประเภทและแสดงปุ่ม "เพิ่มขอบข่ายร่วม"
        typesContainer.html(`<a class="btn btn-primary btn-xs add-lab-scope data-type="${undefined}" data-branch="${branch_id}">เพิ่มขอบข่ายร่วม</a>`);
    } else {
        // แสดงปุ่มประเภทตามปกติ
        var address = lab_addresses_array[branch_id];
        var typesHtml = '';

        if (address.lab_types.pl_2_1_branch) {
            var tooltipText = branchFacilityTypes[0].text; 
            typesHtml += `<a class="btn btn-primary btn-xs add-lab-scope" data-type="1" data-branch="${branch_id}" title="${tooltipText}">ประเภท 1</a> `;
        }
        if (address.lab_types.pl_2_2_branch) {
            var tooltipText = branchFacilityTypes[1].text; 
            typesHtml += `<a class="btn btn-success btn-xs add-lab-scope" data-type="2" data-branch="${branch_id}" title="${tooltipText}">ประเภท 2</a> `;
        }
        if (address.lab_types.pl_2_3_branch) {
            var tooltipText = branchFacilityTypes[2].text; 
            typesHtml += `<a class="btn btn-info btn-xs add-lab-scope" data-type="3" data-branch="${branch_id}" title="${tooltipText}">ประเภท 3</a> `;
        }
        if (address.lab_types.pl_2_4_branch) {
            var tooltipText = branchFacilityTypes[3].text; 
            typesHtml += `<a class="btn btn-warning btn-xs add-lab-scope" data-type="4" data-branch="${branch_id}" title="${tooltipText}">ประเภท 4</a> `;
        }
        if (address.lab_types.pl_2_5_branch) {
            var tooltipText = branchFacilityTypes[4].text; 
            typesHtml += `<a class="btn btn-danger btn-xs add-lab-scope" data-type="5" data-branch="${branch_id}" title="${tooltipText}">ประเภท 5</a> `;
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
    // ดึงข้อมูล lab_main_address จาก sessionStorage
    
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || {};

    // ตรวจสอบสถานะของ checkbox_main
    var isChecked = $(this).is(':checked');
    lab_main_address.checkbox_main = isChecked ? 1 : 0;

    // อัปเดตค่าใน sessionStorage
    sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));

    // อัปเดต UI ตามสถานะของ checkbox
    var mainTypesContainer = $('#main-branch-container');


    if(isChecked) {
        mainTypesContainer.html(`<a class="btn btn-primary btn-xs add-lab-main-scope" data-type="${undefined}" data-branch="${undefined}">เพิ่มขอบข่ายร่วม</a>`);
    } else {
        var typesHtml = '';
        for (var i = 1; i <= 5; i++) {
            var checkboxId = '#pl_2_' + i;
            var buttonClass = buttonColors[i - 1];
            var buttonText = 'ประเภท ' + i;

            // if ($(checkboxId).is(':checked')) {
            //     typesHtml += `<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="${undefined}">${buttonText}</a>`;
            // }

            if ($(checkboxId).is(':checked')) {
                var tooltipText = mainFacilityTypes[i - 1].text;  // หาค่า tooltip ที่ตรงกับประเภท
                typesHtml += `<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="${undefined}" title="${tooltipText}">${buttonText}</a>`;
            }
        }
        mainTypesContainer.html(typesHtml);
    }
});

var previousStates = {}; // ใช้เก็บสถานะ checked/uncheck ของ checkbox แต่ละตัว

$(document).ready(function () {
    // กำหนดค่าเริ่มต้นสำหรับ previousStates
    $('.check_main').each(function () {
        var i = $(this).data('id'); // ดึงค่า data-id ของ checkbox
        var isChecked = $(this).prop('checked'); // ตรวจสอบว่า checkbox ถูก check อยู่หรือไม่
        previousStates[i] = isChecked; // บันทึกสถานะเริ่มต้นลงใน previousStates
    });

    console.log('Initial previousStates:', previousStates);
});

// เมื่อใดก็ตามที่ checkbox ที่มี class 'check_main' มีการเปลี่ยนแปลง
$('.check_main').on("ifToggled", function(event){
    // ดึงค่า lab_main_address จาก sessionStorage หรือกำหนดค่าเริ่มต้น
    var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || {};
    var isChecked = $(this).prop('checked');
    var mainTypesContainer = $('#main-branch-container');
    var checkboxMainBranchContainer = $('#checkbox-main-branch-container');
    var i = $(this).data('id'); // ดึงค่า data-id จาก checkbox ที่ถูกคลิก
    var buttonClass = buttonColors[i - 1]; 
    var tooltipText = mainFacilityTypes[i - 1].text;  

    let checkedCount = countChecked(); // ฟังก์ชันนับจำนวน checkbox ที่ถูกเลือก


    // const isChecked = $(this).prop('checked'); // สถานะปัจจุบันก่อนการเปลี่ยน

    const key = 'pl_2_' + i + '_main';

    if (!isChecked && previousStates[i] && Array.isArray(lab_main_address.lab_types[key])) {

        const checkbox = $(this);
        // labTypes = lab_main_address[0].lab_types
      
        const confirmation = confirm(`พบขอบข่ายในรายการ ${tooltipText} ต้องการยกเลิกและลบขอบข่ายประเภทสถานปฏิบัติการนี้`);
        if (!confirmation) {
            checkbox.iCheck('check'); // เปลี่ยนสถานะ checkbox

            setTimeout(function() {
                var checkboxDiv = checkbox.closest('div.icheckbox_flat-red');
                // ตรวจสอบว่า checkbox ยังเป็น checked อยู่
                if (!checkboxDiv.hasClass('checked')) {
                    checkboxDiv.addClass('checked');
                }
            }, 1);  
            return false;  // หยุดการเปลี่ยนแปลงสถานะ
        }else{
            lab_main_address.lab_types['pl_2_' + i + '_main'] = 0
            // console.log(lab_main_address)
            sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));
            renderCalScopeWithParameterTable();
        }
    }



    // หากเปลี่ยนสถานะสำเร็จ อัปเดต previousStates
    previousStates[i] = isChecked;

    if (checkedCount === 1) {
        if (checkboxMainBranchContainer.find('div.checkbox-success').length === 0) {
            checkboxMainBranchContainer.append(`
                <div class="checkbox checkbox-success">
                    <input id="checkbox_main" type="checkbox" data-branch="${undefined}" >
                    <label for="checkbox_main">
                        <span class="font-16"></span>
                    </label>
                </div>
            `);
        }

        if (isChecked) {
            if (mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).length === 0) {
                mainTypesContainer.append(`<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="${undefined}" title="${tooltipText}">ประเภท ${i}</a>`);
            }
        } else {
            mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
        }
    } else if (checkedCount === 0) {
        checkboxMainBranchContainer.find('div.checkbox-success').remove();
        mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
    } else {
        var checkboxMain = $('#checkbox_main');
        
        $('#checkbox_main').iCheck(lab_main_address.checkbox_main != 0 ? 'check' : 'uncheck');
       
        if (checkboxMain.is(':checked')) {
            console.log('checkbox_main is checked');
            mainTypesContainer.html(`<a class="btn btn-primary btn-xs add-lab-main-scope" data-type="${undefined}" data-branch="${undefined}">เพิ่มขอบข่ายร่วม</a>`);
        } else {
            if (isChecked) {
                if (mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).length === 0) {
                    mainTypesContainer.append(`<a class="btn ${buttonClass} btn-xs add-lab-main-scope" style="margin-left:2px !important; margin-right:2px !important" data-type="${i}" data-branch="${undefined}" title="${tooltipText}">ประเภท ${i}</a>`);
                }
            } else {
                mainTypesContainer.find(`a.add-lab-main-scope[data-type="${i}"]`).remove();
            }
        }
    }

    // อัปเดต lab_main_address ตามสถานะของ checkbox ที่เปลี่ยนแปลง
    var existingValue = lab_main_address.lab_types['pl_2_' + i + '_main'];
    var newValue = isChecked ? (Array.isArray(existingValue) ? existingValue : 1) : 0;
    lab_main_address.lab_types['pl_2_' + i + '_main'] = newValue;

    // บันทึก lab_main_address กลับไปยัง sessionStorage
    sessionStorage.setItem('lab_main_address', JSON.stringify(lab_main_address));

    console.log('Checkbox change detected for item ' + i);
    // console.log(lab_main_address);
});

// ตรวจสอบสถานะของ #checkbox_main เมื่อโหลดหน้าเว็บ
if ($('#checkbox_main').length > 0) {
    // var lab_main_address = JSON.parse(sessionStorage.getItem('lab_main_address')) || { lab_types: {} };
    $('#checkbox_main').iCheck(lab_main_address.checkbox_main != 0 ? 'check' : 'uncheck');
}

        // ฟังก์ชันสำหรับการดึงคำอธิบายประเภทสถานที่
        function getFacilityTypeDescription(input) {
            // ตัดคำว่า '_branch' หรือ '_main' ออกจาก input
            const key = input.replace(/_(branch|main)$/, '');
            // คืนค่าคำอธิบายประเภทสถานที่ ถ้าไม่เจอให้คืนค่า 'Unknown facility type'
            return facilityTypes[key] || 'Unknown facility type';
        }
    
        function renderLabTypesMainTransactions(labTypes,wrapper) {
            let html = '<h4 style="margin-bottom: 20px !important">ขอบข่ายที่ยื่นขอรับการรับรองสำหรับสำนักงานใหญ่</h4>';
    
            // Loop through each lab_type group
            $.each(labTypes, function (siteType, transactionsGroup) {
                if (!Array.isArray(transactionsGroup) || transactionsGroup.length === 0) {
                    return; // Skip if the group is empty
                }
    
                // Sort transactionsGroup by cal_main_branch_text (alphabetically)
                transactionsGroup.sort(function (a, b) {
                    return (a.cal_main_branch_text || '').localeCompare(b.cal_main_branch_text || '');
                });
    
                html += '<h4 class="text-success" style="margin-left: 20px !important"> - ' + getFacilityTypeDescription(siteType) + '</h4>';
                
                html += '<table class="table table-bordered"><thead class="bg-primary"><tr>';
                html += '<th class="text-center text-white" width="15%">สาขาทดสอบ</th>';
                html += '<th class="text-center text-white" width="20%">เครื่องมือ1</th>';
                html += '<th class="text-center text-white" width="15%">เครื่องมือ2</th>';
                html += '<th class="text-center text-white" width="15%">พารามิเตอร์1</th>';
                html += '<th class="text-center text-white" width="15%">พารามิเตอร์2</th>';
                html += '<th class="text-center text-white" width="20%">วิธีสอบเทียบ</th>';
                html += '</tr></thead><tbody>';
    
                $.each(transactionsGroup, function (index, transaction) {
                    html += '<tr>';
                    html += '<td>' + (transaction.cal_main_branch_text ?? '') + '</td>';
                    html += '<td>' + (transaction.cal_instrumentgroup_text ?? '') + '</td>';
                    html += '<td>' + (transaction.cal_instrument_text ?? '') + '</td>';
                    html += '<td>' + (transaction.cal_parameter_one_text ?? '') + (transaction.cal_parameter_one_value ?? '') + '</td>';
                    html += '<td>' + (transaction.cal_parameter_two_text ?? '') + (transaction.cal_parameter_two_value ?? '') + '</td>';
                    html += '<td>' + (transaction.cal_method ?? '') + '</td>';
                    html += '</tr>';
                });
    
                html += '</tbody></table>';
            });
    
            $(wrapper).append(html);
        }
    
        function renderLabTypesBranchTransactions(branchLabAdresses, labAddressesArray,wrapper) {
            let html = '<h4 style="margin-bottom: 20px; margin-top:50px; !important">ขอบข่ายที่ยื่นขอรับการรับรองสำหรับสาขา</h4>';
        
            // Loop through each branchLabAdresses and match with labAddressesArray
            $.each(branchLabAdresses, function (branchIndex, branchLabAdresse) {
                let labAddress = labAddressesArray[branchIndex]; // Match with labAddressesArray using the same index
        
                if (labAddress && labAddress.lab_types) {
                    html += '<h4 class="text-warning" style="margin-top: 20px !important">สาขา: ';
                    html += 'เลขที่ ' + (branchLabAdresse.addr_no ?? '') + ' หมู่ที่ ' + (branchLabAdresse.addr_moo ?? '') + ' ';
                    html += 'แขวง/ตำบล' + (labAddress.sub_district_add_modal ?? '') + ' ';
                    html += 'เขต/อำเภอ' + (labAddress.address_city_text_add_modal ?? '') + ' ';
                    html += 'จังหวัด' + (labAddress.address_city_text_add_modal ?? '') + '</h4>';
        
                    // Loop through each lab_type group in lab_types for the branch
                    $.each(labAddress.lab_types, function (siteType, transactionsGroup) {
                        if (!Array.isArray(transactionsGroup) || transactionsGroup.length === 0) {
                            return; // Skip if the group is empty
                        }
        
                        // Sort transactionsGroup by cal_main_branch_text (alphabetically)
                        transactionsGroup.sort(function (a, b) {
                            return (a.cal_main_branch_text || '').localeCompare(b.cal_main_branch_text || '');
                        });
        
                        html += '<h4 class="text-success" style="margin-left: 20px !important"> - ' + getFacilityTypeDescription(siteType) + '</h4>';
                        
                        html += '<table class="table table-bordered"><thead class="bg-primary"><tr>';
                        html += '<th class="text-center text-white" width="15%">สาขาทดสอบ</th>';
                        html += '<th class="text-center text-white" width="20%">เครื่องมือ1</th>';
                        html += '<th class="text-center text-white" width="15%">เครื่องมือ2</th>';
                        html += '<th class="text-center text-white" width="15%">พารามิเตอร์1</th>';
                        html += '<th class="text-center text-white" width="15%">พารามิเตอร์2</th>';
                        html += '<th class="text-center text-white" width="20%">วิธีสอบเทียบ</th>';
                        html += '</tr></thead><tbody>';
        
                        $.each(transactionsGroup, function (index, transaction) {
                            html += '<tr>';
                            html += '<td>' + (transaction.cal_main_branch_text ?? '') + '</td>';
                            html += '<td>' + (transaction.cal_instrumentgroup_text ?? '') + '</td>';
                            html += '<td>' + (transaction.cal_instrument_text ?? '') + '</td>';
                            html += '<td>' + (transaction.cal_parameter_one_text ?? '') + (transaction.cal_parameter_one_value ?? '') + '</td>';
                            html += '<td>' + (transaction.cal_parameter_two_text ?? '') + (transaction.cal_parameter_two_value ?? '') + '</td>';
                            html += '<td>' + (transaction.cal_method ?? '') + '</td>';
                            html += '</tr>';
                        });
        
                        html += '</tbody></table>';
                    });
                }
            });
        
            $(wrapper).append(html);
        }
        







