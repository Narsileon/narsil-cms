import { route } from "ziggy-js";
import { router } from "@inertiajs/react";
import { Slider } from "@/components/ui/slider";
import { TabsContent } from "@/components/ui/tabs";
import useColorStore, { Color, colors } from "@/stores/color-store";
import useRadiusStore from "@/stores/radius-store";
import useThemeStore, { themes } from "@/stores/theme-store";
import useTranslationsStore from "@/stores/translations-store";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
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
import {
  LanguagesIcon,
  PaletteIcon,
  SquareRoundCornerIcon,
  SunMoonIcon,
} from "lucide-react";

function UserSettingsPersonalization() {
  const { color, setColor } = useColorStore();
  const { radius, setRadius } = useRadiusStore();
  const { theme, setTheme } = useThemeStore();
  const { locale, locales, trans } = useTranslationsStore();

  const backgroudColors: Record<Color, string> = {
    default: "bg-neutral-500",
    amber: "bg-amber-500",
    blue: "bg-blue-500",
    cyan: "bg-cyan-500",
    emerald: "bg-emerald-500",
    fuchsia: "bg-fuchsia-500",
    green: "bg-green-500",
    indigo: "bg-indigo-500",
    lime: "bg-lime-500",
    orange: "bg-orange-500",
    pink: "bg-pink-500",
    purple: "bg-purple-500",
    red: "bg-red-500",
    rose: "bg-rose-500",
    sky: "bg-sky-500",
    teal: "bg-teal-500",
    violet: "bg-violet-500",
    yellow: "bg-yellow-500",
  };

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
                  name="language"
                  render={() => (
                    <FormItem className="grid grid-cols-2 justify-between">
                      <div className="flex items-center gap-2">
                        <LanguagesIcon className="size-5" />
                        <FormLabel />
                      </div>
                      <Select
                        value={locale}
                        onValueChange={(value) => {
                          router.patch(route("sessions-locale.update"), {
                            locale: value,
                          });
                        }}
                      >
                        <SelectTrigger className="w-full">
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          {locales.map((locale) => (
                            <SelectItem value={locale} key={locale}>
                              {trans(`locales.${locale}`)}
                            </SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                    </FormItem>
                  )}
                />
                <FormField
                  name="theme"
                  render={() => (
                    <FormItem className="grid w-full grid-cols-2">
                      <div className="flex items-center gap-2">
                        <SunMoonIcon className="size-5" />
                        <FormLabel />
                      </div>
                      <Select value={theme} onValueChange={setTheme}>
                        <SelectTrigger className="w-full">
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          {themes.map((theme) => (
                            <SelectItem value={theme} key={theme}>
                              {trans(`themes.${theme}`)}
                            </SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                    </FormItem>
                  )}
                />
                <FormField
                  name="color"
                  render={() => (
                    <FormItem className="grid w-full grid-cols-2">
                      <div className="flex items-center gap-2">
                        <PaletteIcon className="size-5" />
                        <FormLabel />
                      </div>
                      <Select value={color} onValueChange={setColor}>
                        <SelectTrigger className="w-full">
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          {colors.map((color) => {
                            return (
                              <SelectItem value={color} key={color}>
                                <span
                                  className={`h-3 w-3 rounded-full ${backgroudColors[color]}`}
                                  aria-hidden="true"
                                />
                                {trans(`colors.${color}`)}
                              </SelectItem>
                            );
                          })}
                        </SelectContent>
                      </Select>
                    </FormItem>
                  )}
                />
                <FormField
                  name="radius"
                  render={() => (
                    <FormItem className="grid grid-cols-2 justify-between">
                      <div className="flex items-center gap-2">
                        <SquareRoundCornerIcon className="size-5" />
                        <FormLabel />
                      </div>
                      <Slider
                        value={[radius]}
                        min={0}
                        max={2}
                        step={0.05}
                        onValueChange={([value]) => setRadius(value)}
                      />
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
