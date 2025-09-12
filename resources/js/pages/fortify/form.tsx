import { Link } from "@inertiajs/react";
import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

import { Button } from "@narsil-cms/components/button";
import { Card, CardContent, CardFooter } from "@narsil-cms/components/card";
import { Container } from "@narsil-cms/components/container";
import {
  FormField,
  FormFieldRenderer,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormRoot,
  FormSubmit,
} from "@narsil-cms/components/form";
import { InputPassword } from "@narsil-cms/components/input";
import { useLabels } from "@narsil-cms/components/labels";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/section";
import { type Field, type FormType } from "@narsil-cms/types/forms";

type FortifyFormProps = FormType & {
  data: Record<string, any>;
  status?: string;
};

function FortifyForm({
  action,
  data = {},
  form,
  id,
  method,
  status,
  submitLabel,
  title,
}: FortifyFormProps) {
  const { trans } = useLabels();

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
            <CardContent className="p-6">
              <FormProvider
                id={id}
                action={action}
                elements={form}
                method={method}
                initialValues={data}
                render={() => (
                  <FormRoot className="grid-cols-12 gap-6">
                    {form.map((element, index) =>
                      id === "login-form" &&
                      element.handle === "password" &&
                      !("elements" in element) ? (
                        <FormField
                          id={element.handle}
                          field={element as Field}
                          render={({ value, onFieldChange }) => {
                            return (
                              <FormItem className="col-span-full">
                                <div className="flex items-center justify-between gap-3">
                                  <FormLabel required={true}>
                                    {element.name}
                                  </FormLabel>
                                  <Button
                                    className="font-normal"
                                    size="link"
                                    variant="link"
                                  >
                                    <Link href={route("password.request")}>
                                      {trans("passwords.link")}
                                    </Link>
                                  </Button>
                                </div>
                                <InputPassword
                                  {...(element.settings ?? {})}
                                  id={element.handle}
                                  name={element.handle}
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
                        <FormFieldRenderer element={element} key={index} />
                      ),
                    )}
                    <FormSubmit className="w-full place-self-center">
                      {submitLabel}
                    </FormSubmit>
                  </FormRoot>
                )}
              />
            </CardContent>
            {id === "forgot-password-form" ? (
              <CardFooter className="border-t px-6">
                <Button className="w-full" asChild={true} variant="secondary">
                  <Link href={route("login")}>{trans("ui.back")}</Link>
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
