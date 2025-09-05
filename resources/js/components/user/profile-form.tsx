import { Separator } from "@narsil-cms/components/ui/separator";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { useLabels } from "@narsil-cms/components/ui/labels";
import {
  Form,
  FormFieldRenderer,
  FormProvider,
  FormSubmit,
} from "@narsil-cms/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/ui/section";
import type { FormType } from "@narsil-cms/types/forms";
import { Icon } from "../ui/icon";

type ProfileFormProps = {
  profileForm: FormType;
  updatePasswordForm: FormType;
};

function ProfileForm({ profileForm, updatePasswordForm }: ProfileFormProps) {
  const { trans } = useLabels();

  const auth = useAuth();

  return (
    <>
      <FormProvider
        id={profileForm.id}
        elements={profileForm.form}
        initialValues={{
          avatar: auth?.avatar,
          first_name: auth?.first_name,
          last_name: auth?.last_name,
        }}
        render={() => (
          <Section>
            <SectionHeader className="border-b">
              <SectionTitle level="h2">{trans("ui.account")}</SectionTitle>
              <FormSubmit>
                {profileForm.submitIcon ? (
                  <Icon name={profileForm.submitIcon} />
                ) : null}
                {profileForm.submitLabel}
              </FormSubmit>
            </SectionHeader>
            <SectionContent>
              <Form
                className="grid-cols-12 gap-4"
                method={profileForm.method}
                url={profileForm.url}
              >
                {profileForm.form.map((element, index) => (
                  <FormFieldRenderer element={element} key={index} />
                ))}
              </Form>
            </SectionContent>
          </Section>
        )}
      />
      <Separator />

      <FormProvider
        id={updatePasswordForm.id}
        elements={updatePasswordForm.form}
        render={({ reset, setDefaults }) => (
          <Section>
            <SectionHeader className="border-b">
              <SectionTitle level="h2">{trans("ui.password")}</SectionTitle>
              <FormSubmit>
                {updatePasswordForm.submitIcon ? (
                  <Icon name={updatePasswordForm.submitIcon} />
                ) : null}
                {updatePasswordForm.submitLabel}
              </FormSubmit>
            </SectionHeader>
            <SectionContent>
              <Form
                className="grid-cols-12 gap-4"
                method={updatePasswordForm.method}
                url={updatePasswordForm.url}
                options={{
                  onSuccess: () => {
                    reset?.();
                    setDefaults?.();
                  },
                }}
              >
                {updatePasswordForm.form.map((element, index) => (
                  <FormFieldRenderer element={element} key={index} />
                ))}
              </Form>
            </SectionContent>
          </Section>
        )}
      />
    </>
  );
}

export default ProfileForm;
