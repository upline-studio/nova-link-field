<template>
  <p v-if="!fieldValue">—</p>
  <a v-else-if="showAsHtml" :href="fieldValue" class="link-default" @click.stop v-html="anchorValue" :target="target"/>
  <a v-else :href="fieldValue" class="link-default" @click.stop v-text="anchorValue" :target="target"/>
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  computed: {
    fieldValue() {
      return this.field.value
    },
    anchorValue() {
      return this.field.anchorValue || this.fieldValue
    },
    showAsHtml() {
      return this.field.asHtml;
    },
    target() {
      return this.field.target
    }
  }
}
</script>
