import { Link } from "@inertiajs/react";
import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

import { Button, Card, Heading, InputPassword } from "@narsil-cms/blocks";
import { ContainerRoot } from "@narsil-cms/components/container";
import {
  FormField,
  FormFieldRenderer,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormRoot,
} from "@narsil-cms/components/form";
import { useLabels } from "@narsil-cms/components/labels";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
} from "@narsil-cms/components/section";
import { type FormType } from "@narsil-cms/types";

type FortifyFormProps = FormType & {
  data: Record<string, unknown>;
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
    <ContainerRoot className="gap-6" asChild={true} variant="centered">
      <SectionRoot>
        <SectionHeader>
          <Heading level="h1" variant="h4">
            {title}
          </Heading>
        </SectionHeader>
        <SectionContent>
          <Card
            className="max-w-md"
            contentProps={{ className: "p-6" }}
            footerButtons={
              id === "forgot-password-form"
                ? [
                    {
                      className: "w-full",
                      label: trans("ui.back"),
                      linkProps: { href: route("login") },
                      variant: "secondary",
                    },
                  ]
                : undefined
            }
            footerProps={{ className: "border-t px-6" }}
          >
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
                    "type" in element ? (
                      <FormField
                        id={element.handle}
                        field={element}
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
                  <Button
                    className="col-span-12 w-full"
                    form={id}
                    label={submitLabel}
                    type="submit"
                  />
                </FormRoot>
              )}
            />
          </Card>
        </SectionContent>
      </SectionRoot>
    </ContainerRoot>
  );
}

export default FortifyForm;
