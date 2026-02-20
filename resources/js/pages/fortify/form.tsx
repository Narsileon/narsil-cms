import { Toast } from "@base-ui/react/toast";
import { Link } from "@inertiajs/react";
import { Button } from "@narsil-ui/components/button";
import { CardContent, CardFooter, CardRoot } from "@narsil-ui/components/card";
import { Container } from "@narsil-ui/components/container";
import { FormElement, FormProvider, FormRoot } from "@narsil-ui/components/form";
import Registry from "@narsil-ui/components/form/registry";
import { Heading } from "@narsil-ui/components/heading";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import { useTranslator } from "@narsil-ui/components/translator";
import type { FormData } from "@narsil-ui/types";
import { Fragment, useEffect, useRef } from "react";
import { route } from "ziggy-js";

type FortifyFormProps = {
  data?: Record<string, unknown>;
  form: FormData;
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
            <CardRoot className="max-w-md">
              <CardContent className="p-6">
                <FormProvider
                  id={form.id}
                  action={form.action}
                  steps={form.steps}
                  method={form.method}
                  initialData={data}
                  render={() => {
                    return (
                      <FormRoot className="grid-cols-12 gap-6">
                        {form.steps.map((tab, index) => {
                          return (
                            <Fragment key={index}>
                              {tab.elements?.map((element, index) => {
                                return <FormElement {...element} registry={Registry} key={index} />;
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
