<template>
    <div>
        <h5>Chat Form</h5>
        <br />
        <div class="input-group">
            <input
                id="btn-input"
                type="text"
                name="message"
                class="form-control input-sm"
                placeholder="Type your message here..."
                v-model="message"
                @keyup.enter="sendMessage"
                @keyup="sendTypingEvent"
            />

            <span class="input-group-btn">
                <button
                    class="btn btn-primary btn-sm"
                    id="btn-chat"
                    @click="sendMessage"
                >
                    Send
                </button>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user"],

    data() {
        return {
            message: "",
        };
    },

    methods: {
        sendTypingEvent() {
            Echo.join("chat").whisper("typing", this.user);
        },

        sendMessage() {
            this.$emit("messagesent", {
                user: this.user,
                message: this.newMessage,
            });

            this.newMessage = "";
        },
    },
};
</script>

<style scoped>
div {
    background-color: rgb(247, 255, 240);
    padding: 2rem 0;
}
h5 {
    margin: 1rem 0 5px;
    font-weight: 600;
    font-size: 2rem;
}
</style>