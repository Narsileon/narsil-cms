import { ScrollArea } from "@narsil-cms/components/ui/scroll-area";
import { Separator } from "@narsil-cms/components/ui/separator";
import { SettingsIcon, ShieldCheckIcon, UserPenIcon } from "lucide-react";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useMinMd } from "@narsil-cms/hooks/use-breakpoints";
import ConfigurationForm from "@narsil-cms/components/user/configuration-form";
import ProfileForm from "@narsil-cms/components/user/profile-form";
import SecurityForm from "@narsil-cms/components/user/security-form";
import {
  TabsList,
  Tabs,
  TabsTrigger,
  TabsContent,
} from "@narsil-cms/components/ui/tabs";
import type { FormType } from "@narsil-cms/types/forms";

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
  const { getLabel } = useLabels();

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
            <UserPenIcon />
            {getLabel("ui.account")}
          </TabsTrigger>
        ) : null}
        <TabsTrigger value="configuration">
          <SettingsIcon />
          {getLabel("ui.personalization")}
        </TabsTrigger>
        {auth ? (
          <TabsTrigger value="security">
            <ShieldCheckIcon />
            {getLabel("ui.security")}
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
