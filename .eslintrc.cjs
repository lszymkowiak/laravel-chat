const INLINE_ELEMENTS = require('eslint-plugin-vue/lib/utils/inline-non-void-elements.json');

module.exports = {
    root: true,
    'extends': [
        'plugin:vue/vue3-recommended',
        'eslint:recommended'
    ],
    rules: {
        'no-undef': 'off',
        'no-console': 'warn',
        'no-debugger': 'warn',
        'indent': ['error', 4, {'SwitchCase': 1, ignoredNodes: ['TemplateLiteral']}],
        'vue/html-indent': ['error', 4],
        'vue/script-indent': ['error', 4, {'switchCase': 1}],
        'vue/no-v-html': 0,
        'vue/prop-name-casing': 0,
        'vue/no-mutating-props': 0,
        'vue/max-attributes-per-line': 0,
        'vue/html-closing-bracket-spacing': 0,
        'vue/html-closing-bracket-newline': 0,
        'vue/multi-word-component-names': 0,
        'vue/no-reserved-component-names': 0,
        'vue/singleline-html-element-content-newline': ['error', {
            'ignores': ['pre', 'textarea', 'inertia-link', 'option', 'th', 'td', ...INLINE_ELEMENTS]
        }],
    }
}
