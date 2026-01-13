document.querySelectorAll('.custom-select').forEach(wrapper => {
    const input = wrapper.querySelector('.custom-select-input');
    const valueInput = wrapper.querySelector('.custom-select-value');
    const dropdown = wrapper.querySelector('.custom-select-dropdown');
    const optionLis = Array.from(dropdown.querySelectorAll('.custom-select-option'));

    let dropdownOpen = false;
    let filteredLis = optionLis;
    let selectedIndex = -1;

    function openDropdown() {
        dropdown.classList.remove('hidden');
        dropdownOpen = true;
        selectedIndex = -1;
        highlight();
    }

    function closeDropdown() {
        dropdown.classList.add('hidden');
        dropdownOpen = false;
        selectedIndex = -1;
        highlight();
    }

    function filterOptions(value) {
        filteredLis = [];
        // Remove previous "no options" message if any
        const oldNoOption = dropdown.querySelector('.no-options');
        if (oldNoOption) oldNoOption.remove();

        optionLis.forEach(li => {
            if (li.textContent.toLowerCase().includes(value.toLowerCase())) {
                li.classList.remove('hidden');
                filteredLis.push(li);
            } else {
                li.classList.add('hidden');
            }
        });

        // If no options match, display the message
        if (filteredLis.length === 0) {
            const noLi = document.createElement('li');
            noLi.textContent = 'No matches found.';
            noLi.className = 'no-options px-3 py-2 text-gray-400 cursor-not-allowed select-none';
            dropdown.appendChild(noLi);
        }
        selectedIndex = -1;
        highlight();
    }

    function selectOption(li) {
        input.value = li.textContent.trim();
        valueInput.value = li.getAttribute('data-value');
        closeDropdown();
    }

    input.addEventListener('focus', () => {
        // Always show all options when focused
        filterOptions('');
        openDropdown();
    });

    input.addEventListener('input', (e) => {
        // Filter options as user types
        filterOptions(e.target.value);
        openDropdown();
    });

    input.addEventListener('keydown', (e) => {
        if (!dropdownOpen) return;

        if (e.key === 'ArrowDown') {
            selectedIndex = Math.min(selectedIndex + 1, filteredLis.length - 1);
            highlight();
            e.preventDefault();
        } else if (e.key === 'ArrowUp') {
            selectedIndex = Math.max(selectedIndex - 1, 0);
            highlight();
            e.preventDefault();
        } else if (e.key === 'Enter') {
            if (selectedIndex >= 0 && filteredLis[selectedIndex]) {
                selectOption(filteredLis[selectedIndex]);
                e.preventDefault();
            }
        } else if (e.key === 'Escape') {
            closeDropdown();
            e.preventDefault();
        }
    });

    function highlight() {
        optionLis.forEach(li => li.classList.remove('bg-blue-200'));
        if (selectedIndex >= 0 && filteredLis[selectedIndex]) {
            filteredLis[selectedIndex].classList.add('bg-blue-200');
        }
    }

    optionLis.forEach(li => {
        li.addEventListener('mousedown', (e) => {
            e.preventDefault();
            selectOption(li);
        });
    });

    document.addEventListener('mousedown', (e) => {
        if (!wrapper.contains(e.target)) {
            closeDropdown();
        }
    });
});
