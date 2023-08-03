import { usePage } from "@inertiajs/vue3";

let __ = (key,replacements = {}) => {
    let {translations} = usePage().props;
    let text = translations[key] || key;

    Object.keys(replacements).forEach(key => {
        if(replacements[key]) {
            text = text.replace(`:${key}`,replacements[key])
        }
    })
    return text;
}

export default __;