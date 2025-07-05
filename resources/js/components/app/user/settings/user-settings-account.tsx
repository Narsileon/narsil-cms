import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
import { Separator } from "@/components/ui/separator";
import { TabsContent } from "@/components/ui/tabs";
import { usePage } from "@inertiajs/react";
import useTranslationsStore from "@/stores/translations-store";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormSubmit,
} from "@/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { GlobalProps } from "@/types/global";

function UserSettingsAccount() {
  const { trans } = useTranslationsStore();

  const { first_name, last_name } = usePage<GlobalProps>().props.auth;

  return (
    <TabsContent value="account">
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">
            {trans("ui.account", "Account")}
          </SectionTitle>
        </SectionHeader>
        <SectionContent>
          <FormProvider
            id="user-profile-form"
            initialData={{
              first_name: first_name,
              last_name: last_name,
            }}
            render={() => (
              <Form
                className="grid gap-6"
                method="put"
                url={route("user-profile-information.update")}
              >
                <FormField
                  name="last_name"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel required={true} />
                      <Input
                        autoComplete="family-name"
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormField
                  name="first_name"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel required={true} />
                      <Input
                        autoComplete="given-name"
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormSubmit>{trans("ui.update", "Update")}</FormSubmit>
              </Form>
            )}
          />
        </SectionContent>
      </Section>
      <Separator />
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">
            {trans("ui.password", "Password")}
          </SectionTitle>
        </SectionHeader>
        <SectionContent>
          <FormProvider
            id="user-password-form"
            initialData={{
              current_password: "",
              password: "",
              password_confirmation: "",
            }}
            render={() => (
              <Form
                className="grid gap-6"
                method="put"
                url={route("user-password.update")}
              >
                <FormField
                  name="current_password"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel required={true} />
                      <Input
                        autoComplete="current-password"
                        type="password"
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormField
                  name="password"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel required={true} />
                      <Input
                        autoComplete="new-password"
                        type="password"
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormField
                  name="password_confirmation"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel required={true} />
                      <Input
                        autoComplete="new-password"
                        type="password"
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormSubmit>{trans("ui.update", "Update")}</FormSubmit>
              </Form>
            )}
          />
        </SectionContent>
      </Section>
    </TabsContent>
  );
}

export default UserSettingsAccount;
