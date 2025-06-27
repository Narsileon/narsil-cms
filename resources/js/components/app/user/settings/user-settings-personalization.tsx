import { Combobox } from "@/components/ui/combobox";
import { route } from "ziggy-js";
import { router } from "@inertiajs/react";
import { TabsContent } from "@/components/ui/tabs";
import { useTheme } from "@/components/ui/theme";
import useTranslationsStore from "@/stores/translations-store";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
} from "@/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

function UserSettingsPersonalization() {
  const { theme, setTheme } = useTheme();
  const { locale, locales, trans } = useTranslationsStore();

  const languageOptions = locales.map((code) => ({
    value: code,
    label: trans(`locales.${code}`),
  }));

  return (
    <TabsContent value="personalization">
      <Section>
        <SectionHeader>
          <SectionTitle level="h2">{trans("ui.personalization")}</SectionTitle>
        </SectionHeader>
        <SectionContent>
          <FormProvider
            id="user-personalization-form"
            render={() => (
              <Form className="grid gap-4" method="post" url={route("login")}>
                <FormField
                  name="theme"
                  render={() => (
                    <FormItem className="flex-row justify-between">
                      <FormLabel />
                      <Select value={theme} onValueChange={setTheme}>
                        <SelectTrigger className="w-[180px]">
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="dark">
                            {trans("ui.dark")}
                          </SelectItem>
                          <SelectItem value="light">
                            {trans("ui.light")}
                          </SelectItem>
                          <SelectItem value="system">
                            {trans("ui.system")}
                          </SelectItem>
                        </SelectContent>
                      </Select>
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormField
                  name="language"
                  render={() => (
                    <FormItem className="flex-row justify-between">
                      <FormLabel />
                      <Combobox
                        value={locale}
                        options={languageOptions}
                        setValue={(value) => {
                          router.patch(route("sessions-locale.update"), {
                            locale: value,
                          });
                        }}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
              </Form>
            )}
          />
        </SectionContent>
      </Section>
    </TabsContent>
  );
}

export default UserSettingsPersonalization;
