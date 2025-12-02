export function loader (loadingText = '') {
    return `
    <div class="loader flex items-center justify-center w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" fill="none" stroke="currentColor" class="loader" style="width:5%; height: 5%">
            <circle cx="25" cy="25" r="20" stroke-width="5" opacity="0.3" />
            <circle cx="25" cy="25" r="20" stroke-width="5" stroke-dasharray="125.6" stroke-dashoffset="100" stroke-linecap="round">
                <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite" />
                <animate attributeName="stroke-dashoffset" from="125.6" to="0" dur="1s" repeatCount="indefinite" />
            </circle>
        </svg>
        
        <span class="ml-2">${loadingText}</span>
    </div>
    `
}