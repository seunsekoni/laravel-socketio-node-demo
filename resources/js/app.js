import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import { createApp } from "vue/dist/vue.esm-bundler";

import ChatForm from "./components/ChatForm.vue";
import ChatMessages from "./components/ChatMessages.vue";

const app = createApp({
    data() {
        return {
            messages: [],
            users: [],
            test: "",
        };
    },

    created() {
        this.fetchMessages();

        Echo.join("chat")
            .here((users) => {
                this.users = users;
            })
            .joining((user) => {
                this.users.push(user);
            })
            .leaving((user) => {
                this.users = this.users.filter((u) => u.id !== user.id);
            })
            .listenForWhisper("typing", ({ id, name }) => {
                this.users.forEach((user, index) => {
                    if (user.id === id) {
                        user.typing = true;
                        this.users[index] = user;
                    }
                });
            })
            .listen("MessageSent", (event) => {
                this.messages.push({
                    message: event.message.message,
                    user: event.user,
                });

                this.users.forEach((user, index) => {
                    if (user.id === event.user.id) {
                        user.typing = false;
                        this.users[index] = user;
                    }
                });
            });
    },

    watch: {
        messages: {
            deep: true,
            handler() {
                this.$nextTick(() => this.scrollChatListToBottom());
            },
        },
    },

    methods: {
        fetchMessages() {
            axios.get("/messages").then((response) => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);
            axios.post("/messages", message).then((response) => {
                console.log(response.data);
            });
        },

        scrollChatListToBottom() {
            const latest_message = document.querySelector(
                ".chats .card-body li:last-of-type"
            );
            if (latest_message) {
                latest_message.scrollIntoView({ behavior: "smooth" });
            }
        },
    },
});

app.component("chat-form", ChatForm);
app.component("chat-messages", ChatMessages);

app.mount("#app");

