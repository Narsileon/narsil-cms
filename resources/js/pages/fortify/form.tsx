import { Toast } from "@base-ui/react/toast";
import { Link } from "@inertiajs/react";
import { FormElement, FormProvider, FormRoot } from "@narsil-cms/components/form";
import type { FormType } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import { CardContent, CardFooter, CardRoot } from "@narsil-ui/components/card";
import { Container } from "@narsil-ui/components/container";
import { Heading } from "@narsil-ui/components/heading";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import { useTranslator } from "@narsil-ui/components/translator";
import { Fragment, useEffect, useRef } from "react";
import { route } from "ziggy-js";

type FortifyFormProps = {
  data?: Record<string, unknown>;
  form: FormType;
  status?: string;
  title: string;
};

function FortifyForm({ data, form, status, title }: FortifyFormProps) {
  const { add } = Toast.useToastManager();
  const { trans } = useTranslator();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      add({
        description: status,
      });

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <Container
      className="h-[inherit] min-h-[inherit] justify-center"
      variant="sm"
      render={
        <SectionRoot className="animate-in gap-3 py-4 fade-in-0 slide-in-from-bottom-10">
          <SectionHeader>
            <Heading level="h1" variant="h4">
              {title}
            </Heading>
          </SectionHeader>
          <SectionContent>
            <CardRoot className="max-w-sm">
              <CardContent className="p-6">
                <FormProvider
                  id={form.id}
                  action={form.action}
                  elements={form.tabs}
                  method={form.method}
                  initialValues={data}
                  render={() => {
                    return (
                      <FormRoot className="grid-cols-12 gap-6">
                        {form.tabs.map((tab, index) => {
                          return (
                            <Fragment key={index}>
                              {tab.elements?.map((element, index) => {
                                return <FormElement {...element} key={index} />;
                              })}
                            </Fragment>
                          );
                        })}
                        <Button className="col-span-full w-full" form={form.id} type="submit">
                          {form.submitLabel}
                        </Button>
                      </FormRoot>
                    );
                  }}
                />
              </CardContent>
              {form.id === "forgot-password-form" && (
                <CardFooter className="border-t px-6">
                  <Button
                    className="w-full"
                    variant="secondary"
                    render={<Link href={route("login")}>{trans("ui.back")}</Link>}
                  />
                </CardFooter>
              )}
            </CardRoot>
          </SectionContent>
        </SectionRoot>
      }
    />
  );
}

export default FortifyForm;
