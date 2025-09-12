import {
  FormFieldRenderer,
  FormProvider,
  FormRoot,
  FormSubmit,
} from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/section";
import { SeparatorRoot } from "@narsil-cms/components/separator";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { type FormType } from "@narsil-cms/types";

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
        action={profileForm.action}
        elements={profileForm.form}
        method={profileForm.method}
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
              <FormRoot className="grid-cols-12 gap-4">
                {profileForm.form.map((element, index) => (
                  <FormFieldRenderer element={element} key={index} />
                ))}
              </FormRoot>
            </SectionContent>
          </Section>
        )}
      />
      <SeparatorRoot />
      <FormProvider
        id={updatePasswordForm.id}
        action={updatePasswordForm.action}
        elements={updatePasswordForm.form}
        method={updatePasswordForm.method}
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
              <FormRoot
                className="grid-cols-12 gap-4"
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
              </FormRoot>
            </SectionContent>
          </Section>
        )}
      />
    </>
  );
}

export default ProfileForm;
