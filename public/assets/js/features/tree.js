import { submitForm } from "../services/formService.js";
import { loader } from "../ui/html-ui.js";

const loginForm = document.getElementById('treeForm');

loginForm.addEventListener('submit', async (e) =>{
    e.preventDefault();
    const loginBtn = document.getElementById('submit-btn');
    const loading = loader(' Loading...');
    const formData = new FormData(e.target);
    loginBtn.innerHTML = `${loading}`;

    try {
        const response = await submitForm({
            url: '/trees/store',
            formData,
            buttonId: 'submit-btn',
            errorDisplayId: 'loginResponse', 
        })
        loginBtn.innerHTML = `Submit`;
        alert('Tree registered successfully!');
        window.location.reload();
    } catch (error) {
        console.log(error)
        loginBtn.innerHTML = `Submit`;
    }
});