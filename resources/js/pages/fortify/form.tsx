import { Button } from "@/components/ui/button";
import { Card, CardContent, CardFooter } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Input } from "@/components/ui/input";
import { Head, Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
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

type FortifyFormProps = {
  data: Record<string, any>;
  form: LaravelForm;
  labels: Record<string, string>;
  status?: string;
};

function FortifyForm({ data = {}, form, labels, status }: FortifyFormProps) {
  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(status);

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <>
      <Head title={labels.title} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {labels.title}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card className="max-w-md">
              <CardContent>
                <FormProvider
                  id={form.id}
                  inputs={form.inputs}
                  initialValues={data}
                  render={() => (
                    <Form method={form.method} url={form.action}>
                      {form.inputs.map((input, index) =>
                        form.id === "login-form" && input.id === "password" ? (
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
                                    {labels.password_link}
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
                          <FormInputBlock
                            emptyLabel={form.labels.empty}
                            requiredLabel={form.labels.required}
                            {...input}
                            key={index}
                          />
                        ),
                      )}
                      <FormSubmit>{form.labels.submit}</FormSubmit>
                    </Form>
                  )}
                />
              </CardContent>
              {form.id === "forgot-password-form" ? (
                <CardFooter className="border-t">
                  <Button className="w-full" asChild={true} variant="secondary">
                    <Link href={route("login")}>{labels.back ?? "Back"}</Link>
                  </Button>
                </CardFooter>
              ) : null}
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default FortifyForm;
