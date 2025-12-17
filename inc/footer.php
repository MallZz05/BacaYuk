        </main>
        <footer class="main-footer"><div class="container"><p>&copy; <?= date('Y') ?> BacaYuk! - Menjelajah Dunia Melalui Membaca</p></div></footer>
    </div>
    <div id="imageModal" class="modal"><span class="close-modal">&times;</span><img class="modal-content" id="modalImage"><div id="caption"></div></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const settingsBtn = document.getElementById('settingsBtn');
            const settingsPanel = document.getElementById('settingsPanel');
            const closeSettings = document.getElementById('closeSettings');
            const darkModeToggle = document.getElementById('darkModeToggle');
            const htmlElement = document.documentElement;
            const colorOptions = document.querySelectorAll('.color-option');

            // Load saved settings
            const currentTheme = localStorage.getItem('theme') || 'light';
            const currentColor = localStorage.getItem('color-theme') || 'default';
            if (currentTheme === 'dark') {
                htmlElement.setAttribute('data-theme', 'dark');
                darkModeToggle.checked = true;
            }

            // Color themes
            function applyColor(color) {
                const root = document.documentElement;
                const colors = {
                    'default': ['linear-gradient(135deg, #667eea 0%, #764ba2 100%)', '#667eea', '#764ba2'],
                    'teal': ['linear-gradient(135deg, #0093E9 0%, #80D0C7 100%)', '#0093E9', '#80D0C7'],
                    'orange': ['linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 52%, #2BFF88 90%)', '#FA8BFF', '#2BD2FF'],
                    'red': ['linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', '#f093fb', '#f5576c'],
                    'green': ['linear-gradient(135deg, #0ba360 0%, #3cba92 100%)', '#0ba360', '#3cba92'],
                    'yellow': ['linear-gradient(135deg, #f7971e 0%, #ffd200 100%)', '#f7971e', '#ffd200']
                };
                if (colors[color]) {
                    root.style.setProperty('--primary-gradient', colors[color][0]);
                    root.style.setProperty('--primary-color', colors[color][1]);
                    root.style.setProperty('--secondary-color', colors[color][2]);
                }
            }
            applyColor(currentColor);
            document.querySelector(`.color-option[data-color="${currentColor}"]`)?.classList.add('active');

            // Event Listeners
            settingsBtn.addEventListener('click', () => {
                settingsPanel.style.display = settingsPanel.style.display === 'block' ? 'none' : 'block';
            });

            closeSettings.addEventListener('click', () => {
                settingsPanel.style.display = 'none';
            });

            window.addEventListener('click', (event) => {
                if (!settingsBtn.contains(event.target) && !settingsPanel.contains(event.target)) {
                    settingsPanel.style.display = 'none';
                }
            });

            darkModeToggle.addEventListener('change', () => {
                if (darkModeToggle.checked) {
                    htmlElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    htmlElement.setAttribute('data-theme', 'light');
                    localStorage.setItem('theme', 'light');
                }
            });

            colorOptions.forEach(option => {
                option.addEventListener('click', () => {
                    const color = option.getAttribute('data-color');
                    applyColor(color);
                    localStorage.setItem('color-theme', color);
                    colorOptions.forEach(opt => opt.classList.remove('active'));
                    option.classList.add('active');
                });
            });

            // Image Modal
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById("modalImage");
            const captionText = document.getElementById("caption");
            const closeModal = document.getElementsByClassName("close-modal")[0];
            const images = document.querySelectorAll('.book-cover, .book-cover-detail');

            images.forEach(img => {
                img.style.cursor = 'pointer';
                img.addEventListener('click', function(){
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt;
                });
            });

            closeModal.onclick = function() { modal.style.display = "none"; };
            window.onclick = function(event) { if (event.target == modal) { modal.style.display = "none"; } };
        });
                    // ... (kode JavaScript sebelumnya tetap sama) ...

            // Color themes
            function applyColor(color) {
                const root = document.documentElement;
                const colors = {
                    'default': ['linear-gradient(135deg, #667eea 0%, #764ba2 100%)', '#667eea', '#764ba2'],
                    'teal': ['linear-gradient(135deg, #0093E9 0%, #80D0C7 100%)', '#0093E9', '#80D0C7'],
                    'orange': ['linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 52%, #2BFF88 90%)', '#FA8BFF', '#2BD2FF'],
                    'red': ['linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', '#f093fb', '#f5576c'],
                    'green': ['linear-gradient(135deg, #0ba360 0%, #3cba92 100%)', '#0ba360', '#3cba92'],
                    'yellow': ['linear-gradient(135deg, #f7971e 0%, #ffd200 100%)', '#f7971e', '#ffd200'],
                    // TAMBAHKAN WARNA BARU DI SINI
                    'purple': ['linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%)', '#8E2DE2', '#4A00E0'],
                    'blue': ['linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%)', '#2193b0', '#6dd5ed'],
                    'pink': ['linear-gradient(135deg, #ee9ca7 0%, #ffdde1 100%)', '#ee9ca7', '#ffdde1']
                };
                if (colors[color]) {
                    root.style.setProperty('--primary-gradient', colors[color][0]);
                    root.style.setProperty('--primary-color', colors[color][1]);
                    root.style.setProperty('--secondary-color', colors[color][2]);
                }
            }
            applyColor(currentColor);
            document.querySelector(`.color-option[data-color="${currentColor}"]`)?.classList.add('active');

            // ... (kode JavaScript setelahnya tetap sama) ...
    </script>
</body>
</html>