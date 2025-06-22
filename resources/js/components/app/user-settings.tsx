import { Input } from "@/components/ui/input";
import { Separator } from "@/components/ui/separator";
import { SettingsIcon, UserIcon } from "lucide-react";
import { TabsList, Tabs, TabsContent, TabsTrigger } from "@/components/ui/tabs";
import { useMinMd } from "@/hooks/use-breakpoints";
import { useRoute } from "ziggy-js";
import { useTheme } from "@/components/theme/theme-provider";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  Dialog,
  DialogCloseButton,
  DialogContent,
  DialogProps,
} from "@/components/ui/dialog";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
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

type UserSettingsProps = {
  open: DialogProps["open"];
  onOpenChange: DialogProps["onOpenChange"];
};

function UserSettings({ open, onOpenChange }: UserSettingsProps) {
  const route = useRoute();
  const { theme, setTheme } = useTheme();
  const { locale, locales, trans } = useTranslationsStore();

  const minMd = useMinMd();

  return (
    <>
      <Dialog open={open} onOpenChange={onOpenChange}>
        <DialogContent className="md:p-0" showCloseButton={false}>
          <Tabs
            defaultValue="general"
            orientation={minMd ? "vertical" : "horizontal"}
          >
            <TabsList className="md:border-r">
              {minMd ? (
                <DialogCloseButton className="h-12 pl-2 [&_svg:not([class*='size-'])]:size-5" />
              ) : null}
              <TabsTrigger value="personalization">
                <SettingsIcon />
                {trans("ui.personalization")}
              </TabsTrigger>
              <TabsTrigger value="account">
                <UserIcon />
                {trans("ui.account")}
              </TabsTrigger>
              <TabsTrigger value="security">
                <UserIcon />
                {trans("ui.security")}
              </TabsTrigger>
            </TabsList>
            <Separator orientation={minMd ? "vertical" : "horizontal"} />
            <TabsContent value="personalization">
              <Section>
                <SectionHeader>
                  <SectionTitle level="h2">
                    {trans("ui.personalization")}
                  </SectionTitle>
                </SectionHeader>
                <SectionContent>
                  <Form method="post" url={route("login")}>
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
                          <Select value={locale}>
                            <SelectTrigger className="w-[180px]">
                              <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                              {locales.map((locale) => {
                                return (
                                  <SelectItem value={locale}>
                                    {trans(`locales.${locale}`)}
                                  </SelectItem>
                                );
                              })}
                            </SelectContent>
                          </Select>
                          <FormMessage />
                        </FormItem>
                      )}
                    />
                  </Form>
                </SectionContent>
              </Section>
            </TabsContent>
            <TabsContent value="account">
              <Section>
                <SectionHeader>
                  <SectionTitle level="h2">{trans("ui.account")}</SectionTitle>
                </SectionHeader>
                <SectionContent>Content</SectionContent>
              </Section>
            </TabsContent>
            <TabsContent value="security">
              <Section>
                <SectionHeader>
                  <SectionTitle level="h2">{trans("ui.security")}</SectionTitle>
                </SectionHeader>
                <SectionContent>Content</SectionContent>
              </Section>
            </TabsContent>
          </Tabs>
        </DialogContent>
      </Dialog>
    </>
  );
}

export default UserSettings;
