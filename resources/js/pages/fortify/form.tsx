import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

import { Button, Card, Container, Heading } from "@narsil-cms/blocks";
import {
  FormFieldRenderer,
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
    <Container className="gap-6" asChild={true} variant="centered">
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
                  {form.map((element, index) => {
                    return <FormFieldRenderer element={element} key={index} />;
                  })}
                  <Button
                    className="col-span-12 w-full"
                    form={id}
                    type="submit"
                  >
                    {submitLabel}
                  </Button>
                </FormRoot>
              )}
            />
          </Card>
        </SectionContent>
      </SectionRoot>
    </Container>
  );
}

export default FortifyForm;
