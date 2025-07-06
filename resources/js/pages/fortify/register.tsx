import { Card, CardContent } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Form, FormProvider, FormSubmit } from "@/components/ui/form";
import { Head } from "@inertiajs/react";
import { route } from "ziggy-js";
import FormInputBlock from "@/blocks/form-input-block";
import useTranslationsStore from "@/stores/translations-store";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelForm } from "@/types/global";

type RegisterProps = {
  form: LaravelForm;
};

function Register({ form }: RegisterProps) {
  const { trans } = useTranslationsStore();

  return (
    <>
      <Head title={trans("ui.registration", "Registration")} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {trans("ui.registration", "Registration")}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card>
              <CardContent>
                <FormProvider
                  id="register-form"
                  initialData={{
                    email: "",
                    first_name: "",
                    last_name: "",
                    password_confirmation: "",
                    password: "",
                  }}
                  render={() => (
                    <Form method="post" url={route("register.store")}>
                      {form.inputs.map((input, index) => (
                        <FormInputBlock {...input} key={index} />
                      ))}
                      <FormSubmit className="col-span-full">
                        {trans("ui.register", "Register")}
                      </FormSubmit>
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

export default Register;
