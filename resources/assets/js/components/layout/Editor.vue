<template>
    <textarea ref="area"></textarea>
</template>
<script>
    import SimpleMDE from 'simplemde'
    import store from 'store'
    export default {
        data: () => {
            return {
                mde: ''
            }
        },
        props: ['value'],
        mounted() {
            this.mde = new SimpleMDE({
                autofocus: true,
                element: this.$refs.area,
                autosave: {
                    enabled: true,
                    uniqueId: "editor",
                    delay: 3000,
                },
                spellChecker: false,
                tabSize: 4,
                initialValue: this.content,
                placeholder: "Markdown 编辑器，支持自动保存"
            })

            let self = this
            this.mde.codemirror.on('change', function() {
                self.$emit('input', self.mde.value())
            })

            this.mde.codemirror.on('refresh', function() {
                self.$emit('input', self.mde.value())
            })
        },
        computed: {
            title: function () {
                let title = this.$route.params.name
                return title ? title : ''
            },
            content: function () {
                let content = store.get("archive"+this.title)
                return content ? content.markdown : this.value
            }
        },
        beforeDestroy() {
            this.mde.toTextArea()
        }
}
</script>