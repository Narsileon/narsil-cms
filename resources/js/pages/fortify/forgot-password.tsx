import { Button } from "@/components/ui/button";
import { Card, CardContent, CardFooter } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Form, FormProvider, FormSubmit } from "@/components/ui/form";
import { Head, Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import FormInputBlock from "@/blocks/form-input-block";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelForm } from "@/types/global";

type ForgotPasswordProps = {
  form: LaravelForm;
  status: string;
  translations: Record<string, string>;
};

function ForgotPassword({ form, status, translations }: ForgotPasswordProps) {
  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(status);

      hasStatus.current = true;
    }
  }, [status]);

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
              <CardFooter className="border-t">
                <Button className="w-full" asChild={true} variant="secondary">
                  <Link href={route("login")}>{translations.back}</Link>
                </Button>
              </CardFooter>
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default ForgotPassword;
