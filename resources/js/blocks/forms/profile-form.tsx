import { Icon } from "@narsil-cms/blocks/icon";
import { Button } from "@narsil-cms/components/button";
import { FormElement, FormProvider, FormRoot } from "@narsil-cms/components/form";
import { Heading } from "@narsil-cms/components/heading";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import { Separator } from "@narsil-cms/components/separator";
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
                <Button form={profileForm.id} type="submit">
                  {profileForm.submitIcon && <Icon name={profileForm.submitIcon} />}
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
                <Button form={updatePasswordForm.id} type="submit">
                  {updatePasswordForm.submitIcon && <Icon name={updatePasswordForm.submitIcon} />}
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
