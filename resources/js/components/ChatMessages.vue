<template>
    <ul class="chat">
        <h4>Messages</h4>
        <li class="left clearfix" v-for="message in messages" :key="message.user.name">
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font">
                        {{ message.user.name }}
                    </strong>
                </div>
                <p>
                    {{ message.message }}
                </p>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['messages']
    };
</script>