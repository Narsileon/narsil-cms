import { isEmpty } from "lodash";
import { usePage } from "@inertiajs/react";
import type { Theme } from "@narsil-cms/stores/theme-store";

export type GlobalProps = {
  auth: AuthProps & {
    configuration: ConfigurationProps;
  };
  description: string;
  labels: Record<string, string>;
  locale: string;
  navigation: {
    breadcrumb: {
      href: string;
      label: string;
    }[];
    sidebar?: {
      content: ComponentProps[];
    };
    userMenu: {
      content: ComponentProps[];
    };
  };
  redirect: RedirectProps;
  title: string;
  url: string;
};

type AuthProps = {
  avatar: string | null;
  email: string;
  first_name: string | undefined | null;
  last_name: string | undefined | null;
  two_factor_confirmed_at: string | null;
};

type ComponentProps = Record<string, any> & {
  components: string;
  children?: ComponentProps[];
};

type ConfigurationProps = {
  color: string;
  radius: number;
  theme: Theme;
};

type RedirectProps = {
  data?: Record<string, any>;
  error: string;
  info: string;
  success: string;
  warning: string;
};

export function useAuth() {
  const { auth } = usePage<GlobalProps>().props;

  return isEmpty(auth) ? null : auth;
}

export function useLabels() {
  return usePage<GlobalProps>().props.labels ?? {};
}

export function useLocale() {
  const locale = usePage<GlobalProps>().props.locale ?? "en";

  return { locale };
}

export function useNavigation() {
  return usePage<GlobalProps>().props.navigation ?? {};
}

export function useProps() {
  const props = usePage<GlobalProps>().props;

  return props;
}

export function useRedirect() {
  return usePage<GlobalProps>().props.redirect ?? {};
}
