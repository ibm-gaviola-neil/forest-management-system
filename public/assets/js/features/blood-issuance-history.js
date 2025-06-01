import { fetchData } from "../services/apiService.js";
import { showInfoModal } from "../ui/confirmUI.js";
import { buildInfoDataMap, bloodIssuanceInfo } from '../domain/modal-domain.js'

const serial_number = document.querySelectorAll('.serial_number')

serial_number.forEach(btn => {
    btn.addEventListener('click', async () => {
        const value = btn.value
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> ' + btn.textContent;

        try {
            const data = await fetchData({
                url: `/blood-issuance/get-serial-number?blood_bag_id=${value}`,
            });

            const confirmDataMap = buildInfoDataMap(data);
            showInfoModal({
                bloodIssuanceInfo,
                confirmDataMap,
            });
            btn.innerHTML = btn.textContent;
            
        } catch (err) {
            btn.innerHTML = btn.textContent;
            console.error('Server Error', err);
        }
    })
});