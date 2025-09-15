import { Link } from "@inertiajs/react";
import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

import { InputPassword } from "@narsil-cms/blocks";
import { ButtonRoot } from "@narsil-cms/components/button";
import { Card, CardContent, CardFooter } from "@narsil-cms/components/card";
import { ContainerRoot } from "@narsil-cms/components/container";
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
import { HeadingRoot } from "@narsil-cms/components/heading";
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
          <HeadingRoot level="h1" variant="h4">
            {title}
          </HeadingRoot>
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
                                  <ButtonRoot
                                    className="font-normal"
                                    size="link"
                                    variant="link"
                                  >
                                    <Link href={route("password.request")}>
                                      {trans("passwords.link")}
                                    </Link>
                                  </ButtonRoot>
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
                    <FormSubmit className="col-span-12 w-full">
                      {submitLabel}
                    </FormSubmit>
                  </FormRoot>
                )}
              />
            </CardContent>
            {id === "forgot-password-form" ? (
              <CardFooter className="border-t px-6">
                <ButtonRoot
                  className="w-full"
                  asChild={true}
                  variant="secondary"
                >
                  <Link href={route("login")}>{trans("ui.back")}</Link>
                </ButtonRoot>
              </CardFooter>
            ) : null}
          </Card>
        </SectionContent>
      </SectionRoot>
    </ContainerRoot>
  );
}

export default FortifyForm;
