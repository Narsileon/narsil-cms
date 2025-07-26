import { Button } from "@narsil-cms/components/ui/button";
import { Card, CardContent } from "@narsil-cms/components/ui/card";
import { DialogClose, DialogFooter } from "@narsil-cms/components/ui/dialog";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useModalStore } from "@narsil-cms/stores/modal-store";
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
import type { FormType } from "@narsil-cms/types/forms";
import DialogBody from "@narsil-cms/components/ui/dialog/dialog-body";

type FormProps = {
  data: any;
  form: FormType;
  modal: boolean;
  title: string;
};

function ResourceForm({ modal = false, data, form, title }: FormProps) {
  const { getLabel } = useLabels();

  const { closeTopModal } = useModalStore();

  const { dataFields, mainFields, sidebarFields } = form.fields.reduce(
    (acc, field) => {
      switch (field.handle) {
        case "data":
          acc.dataFields = field.fields;
          break;
        case "sidebar":
          acc.sidebarFields = field.fields;
          break;
        default:
          acc.mainFields.push(field);
          break;
      }
      return acc;
    },
    {
      dataFields: undefined as typeof form.fields | undefined,
      mainFields: [] as typeof form.fields,
      sidebarFields: undefined as typeof form.fields | undefined,
    },
  );

  const content = (
    <>
      <SectionContent className="grid gap-6">
        {mainFields.map((field, index) => {
          return <FormFieldRenderer field={field} key={index} />;
        })}
        {!modal ? <FormSubmit>{form.submit}</FormSubmit> : null}
      </SectionContent>
      {sidebarFields?.length || (dataFields?.length && data?.id) ? (
        <div className="grid gap-4 p-4">
          {sidebarFields?.length ? (
            <Card>
              <CardContent className="grid gap-6">
                {sidebarFields.map((field, index) => {
                  return <FormFieldRenderer field={field} key={index} />;
                })}
              </CardContent>
            </Card>
          ) : null}
          {dataFields?.length && data?.id ? (
            <Card>
              <CardContent className="grid grid-cols-2 justify-between">
                {dataFields.map((field, index) => {
                  return <FormFieldRenderer field={field} key={index} />;
                })}
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
      fields={form.fields}
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
              <DialogBody>{content}</DialogBody>
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
              </SectionHeader>
              {content}
            </Section>
          )}
        </Form>
      )}
    />
  );
}

export default ResourceForm;
