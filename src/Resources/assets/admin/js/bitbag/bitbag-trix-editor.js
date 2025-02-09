document.addEventListener('DOMContentLoaded', async () => {
    if (document.querySelector('trix-editor')) {
        try {
            await import('trix');
            import('trix/dist/trix.css');
        } catch (error) {
            console.error('Error loading Trix: ', error);
        }
    }
});
