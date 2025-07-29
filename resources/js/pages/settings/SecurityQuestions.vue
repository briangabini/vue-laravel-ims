<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
// import { useToast } from '@/components/ui/toast/use-toast';
import { computed } from 'vue';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { PlusCircle, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/admin/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

const props = defineProps({
    allSecurityQuestions: Array,
    userSecurityAnswers: Array,
});

console.log('All Security Questions:', props.allSecurityQuestions);

const form = useForm({
    selectedQuestions: (props.userSecurityAnswers || []).length > 0
        ? (props.userSecurityAnswers || []).map(q => ({ security_question_id: q.security_question_id, answer: q.answer || '' }))
        : [{ security_question_id: '', answer: '' }],
});

const availableQuestions = computed(() => {
    const selectedIds = new Set(form.selectedQuestions.map(q => q.security_question_id));
    return props.allSecurityQuestions.filter(q => !selectedIds.has(q.id) || form.selectedQuestions.some(sq => sq.security_question_id === q.id));
});

const addQuestion = () => {
    form.selectedQuestions.push({ security_question_id: '', answer: '' });
};

const removeQuestion = (index: number) => {
    form.selectedQuestions.splice(index, 1);
};

const submit = () => {
    form.patch(route('security-questions.update'), {
        onSuccess: () => {
            /*toast({
                title: 'Success',
                description: 'Security questions updated successfully.',
            });*/
        },
        onError: (errors) => {

            if (Object.keys(errors).length > 0) {
                errorMessage = Object.values(errors).join(' ');
            }
            // toast error removed
        },
    });
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Security Questions',
        href: '/settings/security-questions',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Security Questions" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall
                    title="Security Questions"
                    description="Choose security questions and provide your answers."
                />
                <Card>
                    <CardHeader>
                        <CardTitle>Security Questions</CardTitle>
                        <CardDescription>Choose security questions and provide your answers.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit">
                            <div class="space-y-4">
                                <div v-for="(selectedQ, index) in form.selectedQuestions" :key="index" class="space-y-4 border-b pb-4">
                                    <div class="w-full space-y-2">
                                        <Label :for="`question-${index}`">Security Question {{ index + 1 }}</Label>
                                        <Select v-model="selectedQ.security_question_id">
                                            <SelectTrigger :id="`question-${index}`">
                                                <SelectValue placeholder="Select a question" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem v-for="q in availableQuestions" :key="q.id" :value="q.id">
                                                    {{ q.question_text }}
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                        <div v-if="form.errors[`selectedQuestions.${index}.security_question_id`]" class="text-red-500 text-sm mt-1">
                                            {{ form.errors[`selectedQuestions.${index}.security_question_id`] }}
                                        </div>
                                    </div>
                                    <div class="w-full space-y-2">
                                        <Label :for="`answer-${index}`">Answer</Label>
                                        <Input
                                            :id="`answer-${index}`"
                                            type="text"
                                            v-model="selectedQ.answer"
                                            class="w-full"
                                            required
                                        />
                                        <div v-if="form.errors[`selectedQuestions.${index}.answer`]" class="text-red-500 text-sm mt-1">
                                            {{ form.errors[`selectedQuestions.${index}.answer`] }}
                                        </div>
                                    </div>
                                    <Button v-if="form.selectedQuestions.length > 1" type="button" variant="destructive" @click="removeQuestion(index)">
                                        <Trash2 class="h-4 w-4" />
                                    </Button>
                                </div>
                            </div>
                            <Button type="button" variant="outline" @click="addQuestion" class="mt-4">
                                <PlusCircle class="mr-2 h-4 w-4" /> Add Another Question
                            </Button>
                            <Button type="submit" :disabled="form.processing" class="mt-6 block">
                                Save
                            </Button>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
