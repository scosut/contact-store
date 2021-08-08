<template>
  <div class="container">
    <h1>Manage Contacts</h1>
    <form
      ref="form"
      @submit.prevent="edit ? updateContact(contact.id) : createContact()"
    >
      <Input
        name="name"
        ref="name"
        v-model="contact.name"
        v-bind:errors="errors.name"
      />
      <Input
        name="email"
        ref="email"
        v-model="contact.email"
        v-bind:errors="errors.email"
      />
      <Input
        name="phone"
        ref="phone"
        v-model="contact.phone"
        v-bind:errors="errors.phone"
      />
      <div class="form-group">
        <button type="submit" class="btn btn-primary" v-show="!edit">
          New Contact
        </button>
        <button type="submit" class="btn btn-primary" v-show="edit">
          Update Contact
        </button>
      </div>
    </form>
    <template v-if="list.length">
      <h2>Contacts</h2>
      <ul class="list-group">
        <li
          class="list-group-item"
          v-for="contact in list"
          v-bind:key="contact.id"
        >
          <div class="row">
            <div class="col-xs-8 col-sm-10">
              <strong>{{ contact.name }}</strong>
              <span class="pipe">|</span>
              {{ contact.email }}
              <span class="pipe">|</span>
              {{ contact.phone }}
            </div>
            <div class="col-xs-4 col-sm-2 text-right">
              <button
                class="btn btn-default btn-xs"
                @click="editContact(contact.id)"
              >
                Edit
              </button>
              <button
                class="btn btn-danger btn-xs"
                @click="deleteContact(contact)"
              >
                Delete
              </button>
            </div>
          </div>
        </li>
      </ul>
    </template>
  </div>
</template>

<script>
import Input from "./Input";

export default {
  components: {
    Input,
  },
  data() {
    return {
      edit: false,
      list: [],
      contact: {
        id: "",
        name: "",
        email: "",
        phone: "",
      },
      errors: {},
    };
  },
  mounted() {
    console.log("Contacts Component Loaded...");
    this.fetchContactList();
  },
  methods: {
    fetchContactList() {
      console.log("Fetching contacts...");
      axios
        .get("api/contacts")
        .then((response) => {
          this.list = response.data;
        })
        .catch((error) => console.log(error));
    },
    createContact() {
      console.log("Creating contact...");
      let params = { ...this.contact };
      axios
        .post("api/contacts", params)
        .then((response) => {
          this.resetForm(response);
        })
        .catch((error) => console.log(error.response.data));
    },
    editContact(id) {
      console.log(`Fetching contact ${id}...`);
      axios
        .get(`api/contacts/${id}`)
        .then((response) => {
          this.edit = true;
          this.contact = response.data;
          delete this.contact.created_at;
          delete this.contact.updated_at;
        })
        .catch((error) => console.log(error));
    },
    updateContact(id) {
      console.log(`Updating contact ${id}...`);
      let params = { ...this.contact, _method: "PATCH" };
      axios
        .post(`api/contacts/${id}`, params)
        .then((response) => {
          this.resetForm(response);
        })
        .catch((error) => console.log(error));
    },
    confirmDelete(name) {
      return confirm(
        `You have chosen to delete ${name}. Click 'OK' to proceed or 'CANCEL to abort.`
      );
    },
    deleteContact(contact) {
      if (this.confirmDelete(contact.name)) {
        console.log(`Deleting contact ${contact.id}...`);
        axios
          .post(`api/contacts/${contact.id}`, { _method: "DELETE" })
          .then(() => {
            this.fetchContactList();
          })
          .catch((error) => console.log(error));
      }
    },
    resetForm(response) {
      if (response.data.success) {
        this.contact.name = "";
        this.contact.email = "";
        this.contact.phone = "";
        this.edit = false;
        this.errors = {};
        this.fetchContactList();
      } else {
        let field = Object.keys(response.data.errors)[0];
        this.$refs[field].$refs[field].focus();
        this.errors = response.data.errors;
      }
    },
  },
};
</script>
