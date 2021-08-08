<template>
  <div
    v-bind:class="errors ? 'form-group has-error has-feedback' : 'form-group'"
  >
    <label class="control-label">{{
      `${name[0].toUpperCase()}${name.slice(1)}`
    }}</label>
    <input
      type="text"
      v-bind:name="name"
      class="form-control"
      :value="value"
      v-bind:ref="name"
      @input="$emit('input', $event.target.value)"
    />
    <template v-if="errors">
      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
      <div class="help-block" role="alert">
        {{ errors[0] }}
      </div>
    </template>
  </div>
</template>

<script>
export default {
  props: ["name", "value", "errors"],
};
</script>