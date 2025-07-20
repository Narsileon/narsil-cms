import { Button } from "@/components/ui/button";
import { Card, CardContent, CardFooter } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Input } from "@/components/ui/input";
import { Head, Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import { useLabels } from "@/components/ui/labels";
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
import type { LaravelForm } from "@/types";

type FortifyFormProps = {
  data: Record<string, any>;
  form: LaravelForm;
  status?: string;
  title: string;
};

function FortifyForm({ data = {}, form, status, title }: FortifyFormProps) {
  const { getLabel } = useLabels();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(status);

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <>
      <Head title={title} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {title}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card className="max-w-md">
              <CardContent>
                <FormProvider
                  id={form.id}
                  fields={form.content}
                  initialValues={data}
                  render={() => (
                    <Form
                      className="gap-6 md:grid-cols-2"
                      method={form.method}
                      url={form.action}
                    >
                      {form.content.map((input, index) =>
                        form.id === "login-form" &&
                        input.handle === "password" ? (
                          <FormField
                            handle={input.handle}
                            render={({ onFieldChange, ...field }) => (
                              <FormItem className="col-span-full">
                                <div className="flex items-center justify-between gap-3">
                                  <FormLabel required={true}>
                                    {input.name}
                                  </FormLabel>
                                  <Link
                                    className="text-xs"
                                    href={route("password.request")}
                                  >
                                    {getLabel("passwords.link")}
                                  </Link>
                                </div>
                                <Input
                                  {...input.settings}
                                  onChange={(e) =>
                                    onFieldChange(e.target.value)
                                  }
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
              </CardContent>
              {form.id === "forgot-password-form" ? (
                <CardFooter className="border-t">
                  <Button className="w-full" asChild={true} variant="secondary">
                    <Link href={route("login")}>{getLabel("ui.back")}</Link>
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
