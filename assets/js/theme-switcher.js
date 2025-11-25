/**
 * Theme Switcher - Cambio de Tema Oscuro/Claro
 */

(function() {
    'use strict';

    // Obtener el tema guardado o usar 'dark' por defecto
    const getTheme = () => {
        return localStorage.getItem('theme') || 'dark';
    };

    // Guardar el tema en localStorage
    const saveTheme = (theme) => {
        localStorage.setItem('theme', theme);
    };

    // Aplicar el tema
    const applyTheme = (theme) => {
        document.documentElement.setAttribute('data-theme', theme);
        
        // Actualizar el icono del botón
        updateThemeIcon(theme);
        
        // Emitir evento personalizado para otros scripts
        document.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: theme } 
        }));
    };

    // Actualizar el icono del botón
    const updateThemeIcon = (theme) => {
        const moonIcon = document.querySelector('.theme-toggle .mdi-moon-waning-crescent');
        const sunIcon = document.querySelector('.theme-toggle .mdi-white-balance-sunny');
        
        if (theme === 'dark') {
            if (moonIcon) moonIcon.style.display = 'block';
            if (sunIcon) sunIcon.style.display = 'none';
        } else {
            if (moonIcon) moonIcon.style.display = 'none';
            if (sunIcon) sunIcon.style.display = 'block';
        }
    };

    // Alternar el tema
    const toggleTheme = () => {
        const currentTheme = getTheme();
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        saveTheme(newTheme);
        applyTheme(newTheme);
        
        // Animación al cambiar
        document.body.style.transition = 'none';
        setTimeout(() => {
            document.body.style.transition = '';
        }, 50);
    };

    // Inicializar el tema al cargar la página
    const initTheme = () => {
        const theme = getTheme();
        applyTheme(theme);
        
        // Agregar listener al botón
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', toggleTheme);
        }
    };

    // Inicializar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTheme);
    } else {
        initTheme();
    }

    // Exponer funciones globalmente si es necesario
    window.themeManager = {
        toggle: toggleTheme,
        get: getTheme,
        set: (theme) => {
            saveTheme(theme);
            applyTheme(theme);
        }
    };

})();