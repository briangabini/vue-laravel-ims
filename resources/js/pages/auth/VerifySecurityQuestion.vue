<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AuthLayout from '@/layouts/AuthLayout.vue';

const props = defineProps({
    email: String,
    securityQuestions: Array,
});

const form = useForm({
    email: props.email,
    security_question_id: '',
    answer: '',
});

const submit = () => {
    form.post(route('password.verify.security'));
};
</script>

<template>
    <AuthLayout title="Verify security question" description="Answer one of your security questions to reset your password">
        <Head title="Verify security question" />

        <Card>
            <CardHeader>
                <CardTitle>Verify security question</CardTitle>
                <CardDescription>Answer one of your security questions to reset your password.</CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <div class="w-full space-y-2">
                            <Label for="question">Security Question</Label>
                            <Select v-model="form.security_question_id">
                                <SelectTrigger id="question">
                                    <SelectValue placeholder="Select a question" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="q in securityQuestions" :key="q.id" :value="q.id">
                                        {{ q.question_text }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <div v-if="form.errors.security_question_id" class="text-red-500 text-sm mt-1">
                                {{ form.errors.security_question_id }}
                            </div>
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="answer">Answer</Label>
                            <Input
                                id="answer"
                                type="text"
                                v-model="form.answer"
                                class="w-full"
                                required
                            />
                            <div v-if="form.errors.answer" class="text-red-500 text-sm mt-1">
                                {{ form.errors.answer }}
                            </div>
                        </div>
                    </div>
                    <Button type="submit" :disabled="form.processing" class="mt-6 block">
                        Submit
                    </Button>
                </form>
            </CardContent>
        </Card>
    </AuthLayout>
</template>
