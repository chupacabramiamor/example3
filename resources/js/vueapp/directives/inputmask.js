import Inputmask from 'inputmask';

export default {
    bind: function (el, binding) {
        (new Inputmask(binding.value)).mask(el);
    }
}
