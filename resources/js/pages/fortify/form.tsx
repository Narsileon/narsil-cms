import { Button } from "@narsil-cms/components/ui/button";
import { Card, CardContent, CardFooter } from "@narsil-cms/components/ui/card";
import { Container } from "@narsil-cms/components/ui/container";
import { Input } from "@narsil-cms/components/ui/input";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import { useLabels } from "@narsil-cms/components/ui/labels";
import {
  Form,
  FormField,
  FormFieldRenderer,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormSubmit,
} from "@narsil-cms/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/ui/section";
import type { FieldType, FormType } from "@narsil-cms/types/forms";

type FortifyFormProps = {
  data: Record<string, any>;
  form: FormType;
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
                items={form.fields}
                initialValues={data}
                render={() => (
                  <Form
                    className="grid-cols-12 gap-6"
                    method={form.method}
                    url={form.url}
                  >
                    {form.fields.map((item, index) =>
                      form.id === "login-form" && item.handle === "password" ? (
                        <FormField
                          field={item as FieldType}
                          render={({ value, onFieldChange }) => {
                            return (
                              <FormItem className="col-span-full">
                                <div className="flex items-center justify-between gap-3">
                                  <FormLabel required={true}>
                                    {item.name}
                                  </FormLabel>
                                  <Link
                                    className="text-xs"
                                    href={route("password.request")}
                                  >
                                    {getLabel("passwords.link")}
                                  </Link>
                                </div>
                                <Input
                                  {...item.settings}
                                  id={item.handle}
                                  name={item.handle}
                                  value={value}
                                  onChange={(event) =>
                                    onFieldChange(event.target.value)
                                  }
                                />
                                <FormMessage />
                              </FormItem>
                            );
                          }}
                          key={index}
                        />
                      ) : (
                        <FormFieldRenderer field={field} key={index} />
                      ),
                    )}
                    <FormSubmit className="w-full place-self-center">
                      {form.submit}
                    </FormSubmit>
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
  );
}

export default FortifyForm;
