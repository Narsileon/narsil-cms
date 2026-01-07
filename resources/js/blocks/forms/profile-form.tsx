import { Button } from "@narsil-cms/blocks/button";
import { Heading } from "@narsil-cms/blocks/heading";
import { Separator } from "@narsil-cms/blocks/separator";
import { FormElement, FormProvider, FormRoot } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import { useAuth } from "@narsil-cms/hooks/use-props";
import type { FormType } from "@narsil-cms/types";
import { Fragment } from "react";

type ProfileFormProps = {
  profileForm: FormType;
  updatePasswordForm: FormType;
};

function ProfileForm({ profileForm, updatePasswordForm }: ProfileFormProps) {
  const { trans } = useLocalization();

  const auth = useAuth();

  return (
    <>
      <FormProvider
        id={profileForm.id}
        action={profileForm.action}
        elements={profileForm.tabs}
        method={profileForm.method}
        initialValues={{
          avatar: auth?.avatar,
          first_name: auth?.first_name,
          last_name: auth?.last_name,
        }}
        render={() => {
          return (
            <SectionRoot>
              <SectionHeader className="border-b">
                <Heading level="h2">{trans("ui.account")}</Heading>
                <Button form={profileForm.id} icon={profileForm.submitIcon} type="submit">
                  {profileForm.submitLabel}
                </Button>
              </SectionHeader>
              <SectionContent>
                <FormRoot className="grid-cols-12 gap-4">
                  {profileForm.tabs.map((tab, index) => {
                    return (
                      <Fragment key={index}>
                        {tab.elements?.map((element, index) => {
                          return <FormElement {...element} key={index} />;
                        })}
                      </Fragment>
                    );
                  })}
                </FormRoot>
              </SectionContent>
            </SectionRoot>
          );
        }}
      />
      <Separator />
      <FormProvider
        id={updatePasswordForm.id}
        action={updatePasswordForm.action}
        elements={updatePasswordForm.tabs}
        method={updatePasswordForm.method}
        render={({ reset, setDefaults }) => {
          return (
            <SectionRoot>
              <SectionHeader className="border-b">
                <Heading level="h2">{trans("ui.password")}</Heading>
                <Button
                  form={updatePasswordForm.id}
                  icon={updatePasswordForm.submitIcon}
                  type="submit"
                >
                  {updatePasswordForm.submitLabel}
                </Button>
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
                  {updatePasswordForm.tabs.map((tab, index) => {
                    return (
                      <Fragment key={index}>
                        {tab.elements?.map((element, index) => {
                          return <FormElement {...element} key={index} />;
                        })}
                      </Fragment>
                    );
                  })}
                </FormRoot>
              </SectionContent>
            </SectionRoot>
          );
        }}
      />
    </>
  );
}

export default ProfileForm;
