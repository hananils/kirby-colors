import Colors from './components/Colors.vue';
import ColorsContrast from './components/ColorsContrast.vue';
import ColorsInput from './components/ColorsInput.vue';
import ColorsOpacity from './components/ColorsOpacity.vue';
import ColorsPicker from './components/ColorsPicker.vue';
import ColorsSpaces from './components/ColorsSpaces.vue';

panel.plugin('hananils/colors', {
    fields: {
        colors: Colors
    },
    components: {
        'k-colors-contrast': ColorsContrast,
        'k-colors-input': ColorsInput,
        'k-colors-opacity': ColorsOpacity,
        'k-colors-picker': ColorsPicker,
        'k-colors-spaces': ColorsSpaces
    }
});
