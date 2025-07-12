import { Card, CardContent } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Head } from "@inertiajs/react";
import { Form, FormProvider, FormSubmit } from "@/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelForm } from "@/types/global";
import FormInputBlock from "@/blocks/form-input-block";

type TwoFactorChallengeProps = {
  form: LaravelForm;
  translations: Record<string, string>;
};

function TwoFactorChallenge({ form, translations }: TwoFactorChallengeProps) {
  return (
    <>
      <Head title={translations.title} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {translations.title}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card>
              <CardContent>
                <FormProvider
                  id={form.id}
                  inputs={form.inputs}
                  render={() => (
                    <Form method={form.method} url={form.action}>
                      {form.inputs.map((input, index) => (
                        <FormInputBlock {...input} key={index} />
                      ))}
                      <FormSubmit>{form.submit}</FormSubmit>
                    </Form>
                  )}
                />
              </CardContent>
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default TwoFactorChallenge;
