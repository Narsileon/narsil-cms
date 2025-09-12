import {
  ConfigurationForm,
  ProfileForm,
  ScrollArea,
  SecurityForm,
} from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import {
  TabsList,
  Tabs,
  TabsTrigger,
  TabsContent,
} from "@narsil-cms/components/tabs";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { type FormType } from "@narsil-cms/types";

type UserSettingsProps = {
  profileForm: FormType;
  twoFactorForm: FormType;
  updatePasswordForm: FormType;
  userConfigurationForm: FormType;
};

function UserSettings({
  profileForm,
  twoFactorForm,
  updatePasswordForm,
  userConfigurationForm,
}: UserSettingsProps) {
  const { trans } = useLabels();

  const auth = useAuth();

  return (
    <Tabs
      className="h-screen overflow-hidden"
      defaultValue={auth ? "account" : "configuration"}
      orientation="vertical"
    >
      <TabsList className="md:border-r">
        {auth ? (
          <TabsTrigger value="account">
            <Icon name="user-edit" />
            {trans("ui.account")}
          </TabsTrigger>
        ) : null}
        <TabsTrigger value="configuration">
          <Icon name="settings" />
          {trans("ui.personalization")}
        </TabsTrigger>
        {auth ? (
          <TabsTrigger value="security">
            <Icon name="shield" />
            {trans("ui.security")}
          </TabsTrigger>
        ) : null}
      </TabsList>
      <ScrollArea className="w-full">
        {auth ? (
          <TabsContent value="account">
            <ProfileForm
              profileForm={profileForm}
              updatePasswordForm={updatePasswordForm}
            />
          </TabsContent>
        ) : null}
        <TabsContent value="configuration">
          <ConfigurationForm form={userConfigurationForm} />
        </TabsContent>
        {auth ? (
          <TabsContent value="security">
            <SecurityForm twoFactorForm={twoFactorForm} />
          </TabsContent>
        ) : null}
      </ScrollArea>
    </Tabs>
  );
}

export default UserSettings;
