import { Button } from "@narsil-cms/blocks/button";
import { Card } from "@narsil-cms/blocks/card";
import { Container } from "@narsil-cms/blocks/container";
import { Heading } from "@narsil-cms/blocks/heading";
import { FormElement, FormProvider, FormRoot } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import type { FormType } from "@narsil-cms/types";
import { Fragment, useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

type FortifyFormProps = {
  data?: Record<string, unknown>;
  form: FormType;
  status?: string;
};

function FortifyForm({ data, form, status }: FortifyFormProps) {
  const { trans } = useLocalization();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(status);

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <Container className="gap-6 overflow-hidden" asChild={true} variant="centered">
      <SectionRoot className="animate-in py-4 fade-in-0 slide-in-from-bottom-10">
        <SectionHeader>
          <Heading level="h1" variant="h4">
            {form.title}
          </Heading>
        </SectionHeader>
        <SectionContent>
          <Card
            className="max-w-md"
            contentProps={{ className: "p-6" }}
            footerButtons={
              form.id === "forgot-password-form"
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
                    <Button className="col-span-12 w-full" form={form.id} type="submit">
                      {form.submitLabel}
                    </Button>
                  </FormRoot>
                );
              }}
            />
          </Card>
        </SectionContent>
      </SectionRoot>
    </Container>
  );
}

export default FortifyForm;
