import { Button } from "@narsil-cms/components/ui/button";
import { Card, CardContent } from "@narsil-cms/components/ui/card";
import { Fragment } from "react";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import {
  DialogBody,
  DialogClose,
  DialogFooter,
} from "@narsil-cms/components/ui/dialog";
import {
  FormProvider,
  Form,
  FormSubmit,
  FormFieldRenderer,
} from "@narsil-cms/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/ui/section";
import type { FieldSetType, FormType } from "@narsil-cms/types/forms";

type FormProps = {
  data: any;
  form: FormType;
  modal: boolean;
  title: string;
};

function ResourceForm({ modal = false, data, form, title }: FormProps) {
  const { getLabel } = useLabels();

  const { closeTopModal } = useModalStore();

  const { sidebar, sidebarInformation, tabs } = form.fields.reduce(
    (acc, field) => {
      if (!("items" in field)) {
        return acc;
      }

      switch (field.handle) {
        case "sidebar":
          acc.sidebar = field;
          break;
        case "sidebar_information":
          acc.sidebarInformation = field;
          break;
        default:
          acc.tabs.push(field);
          break;
      }

      return acc;
    },
    {
      sidebar: undefined as FieldSetType | undefined,
      sidebarInformation: undefined as FieldSetType | undefined,
      tabs: [] as FieldSetType[],
    },
  );

  const mainContent = tabs.map((tab, index) => {
    return (
      <Fragment key={index}>
        {tab.items.map((item, index) => {
          return <FormFieldRenderer item={item} key={index} />;
        })}
      </Fragment>
    );
  });

  const sidebarContent = sidebar?.items.map((item, index) => {
    return <FormFieldRenderer item={item} key={index} />;
  });

  const sidebarInformationContent = sidebarInformation?.items.map(
    (item, index) => {
      return <FormFieldRenderer item={item} key={index} />;
    },
  );

  const content = (
    <>
      {sidebarContent || (sidebarInformationContent && data?.id) ? (
        <div className="grid">
          {sidebarContent ? (
            <Card>
              <CardContent className="grid gap-6">{sidebarContent}</CardContent>
            </Card>
          ) : null}
          {sidebarInformationContent && data?.id ? (
            <Card>
              <CardContent className="grid grid-cols-2 justify-between">
                {sidebarInformationContent}
              </CardContent>
            </Card>
          ) : null}
        </div>
      ) : null}
    </>
  );

  return (
    <FormProvider
      id={form.id}
      items={form.fields}
      initialValues={{
        _back: modal,
        ...data,
      }}
      render={() => (
        <Form
          method={form.method}
          url={form.url}
          options={{
            onSuccess: () => {
              if (modal) {
                closeTopModal();
              }
            },
          }}
        >
          {modal ? (
            <>
              <DialogBody>{mainContent}</DialogBody>
              <DialogFooter className="h-fit border-t">
                <DialogClose asChild={true}>
                  <Button variant="ghost">{getLabel("ui.cancel")}</Button>
                </DialogClose>
                <FormSubmit className="place-self-auto">
                  {form.submit}
                </FormSubmit>
              </DialogFooter>
            </>
          ) : (
            <Section className="p-4">
              <SectionHeader>
                <SectionTitle level="h1" variant="h4">
                  {title}
                </SectionTitle>
                <FormSubmit>{form.submit}</FormSubmit>
              </SectionHeader>
              <SectionContent className="grid gap-6">
                {mainContent}
                {content}
              </SectionContent>
            </Section>
          )}
        </Form>
      )}
    />
  );
}

export default ResourceForm;
