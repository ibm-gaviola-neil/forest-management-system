export const confirmAttr = [
    {
        label: 'Issue To',
        id: 'td_issue_to',
    },
    {
        label: 'Department / Office',
        id: 'td_department',
    },
    {
        label: 'Patient Name',
        id: 'td_patient_name',
    },
    {
        label: 'Requestor',
        id: 'td_requestor',
    },
    {
        label: 'Blood Unit Serial Number',
        id: 'td_serial_number',
    },
    {
        label: 'Blood Type',
        id: 'td_blood_type',
    },
    {
        label: 'Expiration Date',
        id: 'td_expiration',
    },
    {
        label: 'Date of Crossmatch',
        id: 'td_date_crossmatch',
    },
    {
        label: 'Time of Crossmatch',
        id: 'td_time_crossmatch',
    },
    {
        label: 'Release By',
        id: 'td_release_by',
    },
    {
        label: 'Taken By',
        id: 'td_taken_by',
    },
    {
        label: 'Release Date',
        id: 'td_release_date',
    },
];

export const bloodIssuanceInfo = [
    {
        label: 'Donated By',
        id: 'td_donated_by',
    },
    {
        label: 'Blood Unit Serial Number',
        id: 'td_serial_number',
    },
    {
        label: 'Blood Type',
        id: 'td_blood_type',
    },
    {
        label: 'Expiration Date',
        id: 'td_expiration',
    },
    {
        label: 'Date Processed',
        id: 'td_date_process',
    },
];

export function buildInfoDataMap(data) {
    return {
        'td_donated_by': `${data[0].last_name}, ${data[0].first_name}`,
        'td_serial_number': data[0].blood_bag_id,
        'td_blood_type': data[0].blood_type,
        'td_expiration': data[0].expiration_date,
        'td_date_process': data[0].date_process,
    };
}

export function buildConfirmDataMap(data) {
    console.log(data.payload.data.patient);
    
    var elements = {
        'td_issue_to': `${data.payload.data.issue_to}`,
        'td_requestor': `${data.payload.data.requestor.last_name}, ${data.payload.data.requestor.first_name}`,
        'td_serial_number': data.payload.data.serial_number,
        'td_blood_type': data.payload.data.blood_type,
        'td_expiration': data.payload.data.expiration_date,
        'td_date_crossmatch': data.payload.data.date_of_crossmatch,
        'td_time_crossmatch': data.payload.data.time_of_crossmatch,
        'td_release_by': `${data.payload.data.release_by.last_name}, ${data.payload.data.release_by.first_name}`,
        'td_taken_by': `${data.payload.data.taken_by.last_name}, ${data.payload.data.taken_by.first_name}`,
        'td_release_date': data.payload.data.release_date
    };

    if (data.payload.data.patient !== null) {
        elements['td_patient_name'] = `${data.payload.data.patient.last_name}, ${data.payload.data.patient.first_name}`;
    }

    if (data.payload.data.department !== null) {
        elements['td_department'] = `${data.payload.data.department.department_name}`;
    }

    return elements;
}