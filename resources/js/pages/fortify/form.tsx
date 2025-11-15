import { Button, Card, Container, Heading } from "@narsil-cms/blocks";
import { FormProvider, FormRenderer, FormRoot } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import type { FormType } from "@narsil-cms/types";
import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

type FortifyFormProps = {
  form: FormType;
  status?: string;
};

function FortifyForm({ form, status }: FortifyFormProps) {
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
              elements={form.layout}
              method={form.method}
              initialValues={form.data}
              render={() => {
                return (
                  <FormRoot className="grid-cols-12 gap-6">
                    {form.layout.map((element, index) => {
                      return <FormRenderer {...element} key={index} />;
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
