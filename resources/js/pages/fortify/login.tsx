import { Card, CardContent } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Input } from "@/components/ui/input";
import { Head, Link } from "@inertiajs/react";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import { route } from "ziggy-js";
import FormInputBlock from "@/blocks/form-input-block";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormSubmit,
} from "@/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelForm } from "@/types/global";

type LoginProps = {
  form: LaravelForm;
  status?: string;
  translations: Record<string, string>;
};

function Login({ form, status, translations }: LoginProps) {
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
                      {form.inputs.map((input, index) =>
                        input.id === "password" ? (
                          <FormField
                            name={input.id}
                            render={({ onChange, ...field }) => (
                              <FormItem className="col-span-full">
                                <div className="flex items-center justify-between gap-3">
                                  <FormLabel required={true} />
                                  <Link
                                    className="text-xs"
                                    href={route("password.request")}
                                  >
                                    {translations.password_link}
                                  </Link>
                                </div>
                                <Input
                                  autoComplete={input.autoComplete}
                                  type={input.type}
                                  onChange={(e) => onChange(e.target.value)}
                                  {...field}
                                />
                                <FormMessage />
                              </FormItem>
                            )}
                            key={index}
                          />
                        ) : (
                          <FormInputBlock {...input} key={index} />
                        ),
                      )}
                      <FormSubmit>{form.submit}</FormSubmit>
                    </Form>
                  )}
                />
                {status}
              </CardContent>
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default Login;
