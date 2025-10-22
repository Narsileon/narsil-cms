import { Button, Card, Container, Heading } from "@narsil-cms/blocks";
import { FormProvider, FormRenderer, FormRoot } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import type { FormType } from "@narsil-cms/types";
import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

type FortifyFormProps = FormType & {
  data: Record<string, unknown>;
  status?: string;
};

function FortifyForm({
  action,
  data = {},
  id,
  layout,
  method,
  status,
  submitLabel,
  title,
}: FortifyFormProps) {
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
      <SectionRoot className="animate-in fade-in-0 slide-in-from-bottom-10 py-4 duration-500">
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
              elements={layout}
              method={method}
              initialValues={data}
              render={() => {
                return (
                  <FormRoot className="grid-cols-12 gap-6">
                    {layout.map((element, index) => {
                      return <FormRenderer {...element} key={index} />;
                    })}
                    <Button className="col-span-12 w-full" form={id} type="submit">
                      {submitLabel}
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
