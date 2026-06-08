export function debounce(fn, delay = 300) {
    let timer = null;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(null, args), delay);
    };
}
