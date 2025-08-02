<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { LoaderCircle, PlusCircle, Trash2 } from 'lucide-vue-next';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

defineProps({
    securityQuestions: Array,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    security_questions: [{ security_question_id: '', answer: '' }],
});

const addQuestion = () => {
    form.security_questions.push({ security_question_id: '', answer: '' });
};

const removeQuestion = (index: number) => {
    form.security_questions.splice(index, 1);
};

const passwordError = ref('');

const validatePassword = () => {
    const password = form.password;
    const name = form.name.toLowerCase();
    const email = form.email.toLowerCase().split('@')[0];
    const errors = [];

    if (password.length < 8) {
        errors.push('be at least 8 characters');
    }
    if (!/[a-z]/.test(password)) {
        errors.push('contain at least one lowercase letter');
    }
    if (!/[A-Z]/.test(password)) {
        errors.push('contain at least one uppercase letter');
    }
    if (!/\d/.test(password)) {
        errors.push('contain at least one number');
    }
    if ((password.match(/[!@#$%^&*(),.?":{}|<>]/g) || []).length < 2) {
        errors.push('contain at least two symbols');
    }
    if (name && password.toLowerCase().includes(name) && name.length > 0) {
        errors.push('not contain your name');
    }
    if (email && password.toLowerCase().includes(email) && email.length > 0) {
        errors.push('not contain your email');
    }

    if (errors.length > 0) {
        passwordError.value = 'Password must ' + errors.join(', ') + '.';
        return false;
    }

    passwordError.value = '';
    return true;
};

const submit = () => {
    if (validatePassword()) {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    }
};
</script>

<template>
    <AuthBase title="Create an account" description="Enter your details below to create your account">
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Full name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        v-model="form.password"
                        @blur="validatePassword"
                        placeholder="Password"
                    />
                    <InputError :message="form.errors.password || passwordError" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <div v-for="(question, index) in form.security_questions" :key="index" class="grid gap-2">
                    <Label :for="`security_question_${index}`">Security Question {{ index + 1 }}</Label>
                    <Select v-model="question.security_question_id">
                        <SelectTrigger :id="`security_question_${index}`">
                            <SelectValue placeholder="Select a question" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="q in securityQuestions" :key="q.id" :value="q.id">
                                {{ q.question_text }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors[`security_questions.${index}.security_question_id`]" />

                    <Label :for="`security_answer_${index}`">Answer</Label>
                    <Input :id="`security_answer_${index}`" type="text" required v-model="question.answer" placeholder="Answer" />
                    <InputError :message="form.errors[`security_questions.${index}.answer`]" />

                    <Button v-if="form.security_questions.length > 1" type="button" variant="destructive" @click="removeQuestion(index)">
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <Button type="button" variant="outline" @click="addQuestion">
                    <PlusCircle class="mr-2 h-4 w-4" /> Add Another Question
                </Button>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Log in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
