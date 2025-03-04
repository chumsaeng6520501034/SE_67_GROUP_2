export async function loadProvinces(provinceSelectId, amphoeSelectId, tambonSelectId) {
    const response = await fetch("https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province.json");
    const provinces = await response.json();
    let provinceSelect = $(`#${provinceSelectId}`);

    // เคลียร์ค่าเก่า
    provinceSelect.empty().append(new Option("เลือกจังหวัด", "", true, true));

    provinces.forEach(province => {
        provinceSelect.append(new Option(province.name_th, province.name_th)); // ใช้ชื่อเป็น value
    });

    // ใช้ Select2
    provinceSelect.select2();

    provinceSelect.on("change", function () {
        const selectedProvince = provinces.find(province => province.name_th === this.value);
        if (selectedProvince) {
            loadAmphoes(selectedProvince.id, this.value, amphoeSelectId, tambonSelectId);
        }
    });
}

export async function loadAmphoes(provinceId, provinceName, amphoeSelectId, tambonSelectId) {
    const response = await fetch("https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_amphure.json");
    const amphoes = await response.json();
    let amphoeSelect = $(`#${amphoeSelectId}`);

    // เคลียร์ค่าเก่า
    amphoeSelect.empty().append(new Option("เลือกอำเภอ", "", true, true));

    // กรองอำเภอที่อยู่ในจังหวัดที่เลือกโดยใช้ province_id
    const filteredAmphoes = amphoes.filter(amphoe => amphoe.province_id == provinceId);
    
    filteredAmphoes.forEach(amphoe => {
        amphoeSelect.append(new Option(amphoe.name_th, amphoe.name_th)); // ใช้ชื่อเป็น value
    });

    amphoeSelect.select2();

    amphoeSelect.on("change", function () {
        const selectedAmphoe = filteredAmphoes.find(amphoe => amphoe.name_th === this.value);
        if (selectedAmphoe) {
            loadTambons(selectedAmphoe.id, this.value, tambonSelectId);
        }
    });
}

export async function loadTambons(amphoeId, amphoeName, tambonSelectId) {
    const response = await fetch("https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_tambon.json");
    const tambons = await response.json();
    let tambonSelect = $(`#${tambonSelectId}`);

    // เคลียร์ค่าเก่า
    tambonSelect.empty().append(new Option("เลือกตำบล", "", true, true));

    // กรองตำบลที่อยู่ในอำเภอที่เลือกโดยใช้ amphure_id
    tambons.filter(tambon => tambon.amphure_id == amphoeId).forEach(tambon => {
        tambonSelect.append(new Option(tambon.name_th, tambon.name_th)); // ใช้ชื่อตำบลเป็น value
    });

    tambonSelect.select2();
}

document.addEventListener("DOMContentLoaded", () => {
    loadProvinces("province", "amphoe", "tambon");
});
